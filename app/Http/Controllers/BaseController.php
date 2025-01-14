<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseController
{
    /**
     * Format success response.
     *
     * @param string $message
     * @param mixed|null $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function sendSuccessResponse(string $message, mixed $data = null, int $statusCode = 200): JsonResponse
    {
        if ($data === null) {
            $data = new \stdClass();
        }
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Format error response.
     *
     * @param NotFoundHttpException|ModelNotFoundException|Exception|string $e
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function sendErrorResponse( NotFoundHttpException|ModelNotFoundException|Exception|string $e, int $statusCode,): JsonResponse
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Not found',
            ], 404);
        }

        return response()->json([
            'success' => false,
            'message' => $e instanceof Exception ? $e->getMessage() : $e,
        ], $statusCode);
    }

    /**
     * Handle API request.
     *
     * @param Request $request
     * @param Builder $query
     * @param array $with
     * @return array
     */
    protected function handleApiRequest(Request $request, Builder $query, array $with = []): array
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);
        $sortBy = $request->query('sortBy');
        $sortDirection = $request->query('sortDirection', 'asc');
        $selectFields = $request->query('select');

        // Eager load relationships
        if (!empty($with)) {
            $query->with($with);
        }

        // Apply filters
        foreach ($request->query() as $key => $value) {
            if (!in_array($key, ['page', 'limit', 'searchTerm', 'sortBy', 'sortDirection', 'select'])) {
                if ($request->query('where')) {
                    continue;
                }
                $query->where($key, $value);
            }
        }

        // Check for the 'where' parameter
        if ($request->query('where')) {
            $filter = $request->query('where');
            $parts = explode(',', $filter);

            if (count($parts) >= 2) {
                $relationFlag = $parts[0]; // First part: "with:user" or column name
                $column = $parts[1];
                $value = $parts[2] ?? null;

                if (str_starts_with($relationFlag, 'with:')) {
                    // Handle relational filtering
                    $relation = str_replace('with:', '', $relationFlag);
                    if ($value !== null) {
                        $query->whereHas($relation, function ($relationQuery) use ($column, $value) {
                            $relationQuery->where($column, $value);
                        });
                    } else {
                        return ['error' => 'Invalid relational where format. Use where=with:relation,column,value'];
                    }
                } else {
                    // Handle non-relational filtering
                    if ($value === null) {
                        $query->where($relationFlag, $column); // Corrected: Use $relationFlag as column, $column as value
                    } else {
                        return ['error' => 'Invalid where format. Use where=column,value or where=with:relation,column,value'];
                    }
                }
            } else {
                return ['error' => 'Invalid where format. Use where=column,value or where=with:relation,column,value'];
            }
        }

        // Apply search
        $searchTerm = $request->query('searchTerm');
        if ($searchTerm !== null) {
            $columns = Schema::getColumnListing($query->getModel()->getTable());
            $query->where(function ($query) use ($searchTerm, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%$searchTerm%");
                }
            });
        }

        // Apply sorting
        if ($sortBy) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $query->orderBy('created_at', 'desc');

        // Select specific fields
        if ($selectFields !== null) {
            $query->select(explode(',', $selectFields));
        }

        // Fetch results
        if ($limit === 'all') {
            $results = $query->get();
            $total = $results->count();
        } else {
            $results = $query->paginate($limit, ['*'], 'page', $page);
            $total = $results->total();
        }


        // Meta information for pagination
        $meta = [
            'page' => $page,
            'limit' => $limit === 'all' ? $total : $limit,
            'total' => $total,
            'totalPage' => $limit === 'all' ? 1 : $results->lastPage(),
        ];

        // Apply dynamic resource transformation
        $resourceClass = getResourceClass($query->getModel());

        $result = $request->query('select') !== null
            ? ($results instanceof LengthAwarePaginator ? $results->items() : $results->toArray())
            : $resourceClass::collection($results);

        return [
            'meta' => $meta,
            'result' => $result,
        ];

    }
}
