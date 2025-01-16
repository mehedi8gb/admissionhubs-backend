<?php

namespace App\Services\Handlers;

use App\Http\Resources\EmergencyContactResource;
use App\Models\EmergencyContact;

class EmergencyContactHandler extends AbstractHandler
{
    public function handle(array $validatedArray, object $student): array
    {
        if (array_key_exists('emergencyContact', $validatedArray)) {
            $emergencyContact = $validatedArray['emergencyContact'][0];

            // Check for ID to update or create
            if (isset($emergencyContact['id'])) {
                $contact = EmergencyContact::find($emergencyContact['id']);
                $contact->update($emergencyContact);
                $contact->refresh();
                $msg = 'updated';
            } else {
                $emergencyContact['student_id'] = $student->id;
                $contact = EmergencyContact::create($emergencyContact);
                $msg = 'created';
            }

            return [
                'success' => true,
                'message' => 'emergency contact was ' . $msg . ' successfully',
                'data' => EmergencyContactResource::make($contact)
            ];
        }

        return parent::handle($validatedArray, $student);
    }
}
