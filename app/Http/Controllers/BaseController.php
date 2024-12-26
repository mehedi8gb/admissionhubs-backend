<?php

namespace App\Http\Controllers;

use App\Http\Resources\DefaultResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

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
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function sendErrorResponse(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }

    protected function handleApiRequest(Request $request, Builder $query): array
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);
        $sortBy = $request->query('sortBy');
        $sortDirection = $request->query('sortDirection', 'asc');
        $selectFields = $request->query('select');

        // Apply filters
        foreach ($request->query() as $key => $value) {
            if (!in_array($key, ['page', 'limit', 'searchTerm', 'sortBy', 'sortDirection', 'select'])) {
                $query->where($key, $value);
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

        // Apply dynamic resource transformation
        $resourceClass = getResourceClass($query->getModel());
        $result = $results instanceof LengthAwarePaginator
            ? $resourceClass::collection($results->items())
            : $resourceClass::collection($results);

        // Meta information for pagination
        $meta = [
            'page' => $page,
            'limit' => $limit === 'all' ? $total : $limit,
            'total' => $total,
            'totalPage' => $limit === 'all' ? 1 : $results->lastPage(),
        ];

        return compact('meta', 'result');
    }
}
