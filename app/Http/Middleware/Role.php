<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Role
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param ...$role
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next, ...$role): Response|RedirectResponse|JsonResponse
    {
        $userRole = User::staticGetRole() ?: 'guest';

        if (in_array($userRole, $role, true)) {
            return $next($request);
        }

        return throw new NotFoundHttpException();
    }
}
