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


/**
 * Perform a deep merge of two arrays, allowing forced replacement with a "forceReplace" value.
 *
 * @param array $original
 * @param array $new
 * @param string $forceReplaceIndicator
 * @return array
 */
function deepMerge(array $original, array $new, string $forceReplaceIndicator = 'forceReplace'): array
{
    foreach ($new as $key => $value) {
        // Check if the value is marked as a forced replacement
        if ($value === $forceReplaceIndicator) {
            // Replace the key in the original array with an empty value
            $original[$key] = '';
            continue;
        }

        // Check if the new value is empty (null, empty string, or empty array)
        if (is_null($value) || (is_string($value) && trim($value) === '') || (is_array($value) && empty($value))) {
            // Skip overwriting if the new value is empty
            continue;
        }

        if (is_array($value) && isset($original[$key]) && is_array($original[$key])) {
            // Recursively merge arrays
            $original[$key] = deepMerge($original[$key], $value, $forceReplaceIndicator);
        } else {
            // Overwrite scalar values or arrays
            $original[$key] = $value;
        }
    }
    return $original;
}

