<?php

namespace App\Http\Middleware;

use App\Support\Traits\SendResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CodeVerification
{
    use SendResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string $valueName
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next, string $valueName = 'phone')
    {
        if (Redis::get($request->$valueName) !== $request->code) {
            return $this->sendErrorResponse('Код недействителен');
        }

        return $next($request);
    }
}
