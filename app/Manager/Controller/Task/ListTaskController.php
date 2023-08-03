<?php

declare(strict_types=1);

namespace App\Manager\Controller\Task;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ListTaskController
{
    /**
     *  @Route("/list/task")
     */
    public function listTask(): JsonResponse
    {
        return new JsonResponse(200);
    }
}
