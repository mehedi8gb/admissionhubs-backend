<?php

namespace App\Services;

use App\Services\Handlers\ApplicationsHandler;
use App\Services\Handlers\AssignStaffHandler;
use App\Services\Handlers\EmergencyContactHandler;
use App\Services\Handlers\DefaultHandler;
use Throwable;

class NestedRelationService
{
    /**
     * Process the nested arrays using a chain of handlers.
     *
     * @param array $validatedArray
     * @param object $student
     * @return array
     * @throws Throwable
     */
    public static function process(array $validatedArray, object $student): array
    {
        // Define the chain of handlers
        $handler = new ApplicationsHandler();
        $handler
            ->setNext(new EmergencyContactHandler())
            ->setNext(new AssignStaffHandler())
            ->setNext(new DefaultHandler()); // DefaultHandler is dynamic

        // Start the chain
        return $handler->handle($validatedArray, $student);
    }
}

