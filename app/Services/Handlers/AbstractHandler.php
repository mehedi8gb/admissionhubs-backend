<?php

namespace App\Services\Handlers;

use Illuminate\Http\JsonResponse;

abstract class AbstractHandler
{
    private ?AbstractHandler $nextHandler = null;

    public function setNext(AbstractHandler $handler): AbstractHandler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(array $validatedArray, object $student): array
    {
        return $this->nextHandler->handle($validatedArray, $student);
    }
}
