<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @param array $role
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, array ...$role): Response|RedirectResponse
    {
        $userRole = User::staticGetRole() ?: 'guest';

        if (in_array($userRole, $role, true)) {
            return $next($request);
        }

        return throw new NotFoundHttpException();
    }
}
