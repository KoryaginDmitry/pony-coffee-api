<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        $role = auth()->user()?->role->name; 

        if (auth()->user()?->role->name !== 'user') {
            return response()->json(
                [
                    "message" => "Недостаточно прав. Роль этого пользователя - $role, а дожлна быть 'user'"
                ],
                403
            );
        }

        return $next($request);
    }
}
