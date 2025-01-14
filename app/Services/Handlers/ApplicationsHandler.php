<?php

namespace App\Services\Handlers;

use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Throwable;

class ApplicationsHandler extends AbstractHandler
{
    /**
     * @throws Throwable
     */
    public function handle(array $validatedArray, object $student): array
    {
        if (array_key_exists('applications', $validatedArray)) {
            $applications = $validatedArray['applications'][0];

            // Check for ID to update or create
            if (isset($applications['id'])) {
                $application = Application::find($applications['id']);

                // Log status change
                if (isset($applications['status']) && $applications['status'] !== $application->status) {
                    Application::logApplicationStatusChange($applications['status'], $application);
                }

                $application->update($applications);
                $application->refresh();
                $msg = 'updated';
            } else {
                $applications['student_id'] = $student->id;
                $application = Application::create($applications);
                $msg = 'created';
            }

            return [
                'success' => true,
                'message' => 'application was ' . $msg . ' successfully',
                'data' => ApplicationResource::make($application)
            ];
        }

        return parent::handle($validatedArray, $student);
    }
}
