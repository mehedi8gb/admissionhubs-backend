<?php

use App\Http\Resources\DefaultResource;

function getResourceClass($model): string
{
    // Derive the model class name without namespace
    $modelClassName = class_basename($model);

    // Construct the corresponding resource class name
    $resourceClass = "App\\Http\\Resources\\{$modelClassName}Resource";

    // Check if the resource class exists
    if (class_exists($resourceClass)) {
        return $resourceClass;
    }

    // Fallback to a default resource class if not found
    return DefaultResource::class;
}

/**
 * Convert boolean status to 1/0.
 *
 * @param mixed $status
 * @return int
 */
function convertStatus(mixed $status): int
{
    return $status ? 1 : 0;
}
