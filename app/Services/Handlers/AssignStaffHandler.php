<?php

namespace App\Services\Handlers;

use App\Http\Resources\AssignStaffResource;
use App\Models\AssignStaff;
use Exception;

class AssignStaffHandler extends AbstractHandler
{
    /**
     * @throws Exception
     */
    public function handle(array $validatedArray, object $student): array
    {
        if (array_key_exists('assignStaff', $validatedArray)) {
            $nestedData = $validatedArray['assignStaff'][0];
            $model = AssignStaff::find($nestedData['id']);

            if (isset($nestedData['id'])) {
                if ($model->staffId === $nestedData['staffId']) {
                    throw new Exception('You cannot assign the same staff to the same student', 422);
                }

                $model->update($nestedData);
                $model->refresh();
                $msg = 'updated';
            } else {
                $nestedData['student_id'] = $student->id;
                $model = AssignStaff::create($nestedData);
                $msg = 'created';
            }

            return [
                'success' => true,
                'message' => 'staff was ' . $msg . ' successfully',
                'data' => AssignStaffResource::make($model)
            ];
        }

        return parent::handle($validatedArray, $student);
    }
}
