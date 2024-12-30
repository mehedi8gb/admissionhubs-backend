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
 * Includes handling for array deletions based on the forceReplace flag.
 *
 * @param array $original
 * @param array $new
 * @param string $forceReplaceIndicator
 * @return array
 */
function deepMerge(array $original, array $new, string $forceReplaceIndicator = 'forceReplace'): array
{
    foreach ($new as $key => $value) {
        // If value is marked as a forced replacement
        if ($value === $forceReplaceIndicator) {
            // Remove the key from the original array
            unset($original[$key]);
            continue;
        }

        // Skip overwriting with null/empty values
        if (is_null($value) || (is_string($value) && trim($value) === '') || (is_array($value) && empty($value))) {
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


/**
 * Process nested arrays by removing missing indexes and merging incoming data.
 *
 * @param array $existingArray
 * @param array $payloadArray
 * @return array
 */
function processNestedArray(array $existingArray, array $payloadArray): array
{
    // Map payload by unique identifier (e.g., id)
    $payloadMap = collect($payloadArray)->keyBy('id');

    // Filter existing array to retain only indexes present in the payload
    $filteredArray = collect($existingArray)
        ->filter(fn($item) => $payloadMap->has($item['id']))
        ->map(fn($item) => array_merge($item, $payloadMap->get($item['id'])))
        ->values()
        ->toArray();

    // if array fragment same to same then remove 1 index
    return array_map("unserialize", array_unique(array_map("serialize", $filteredArray)));
}

