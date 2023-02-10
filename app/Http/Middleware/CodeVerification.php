<?php

namespace App\Http\Middleware;

use App\Support\Classes\ErrorResponse;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CodeVerification
{
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
        if (Redis::get($request->$valueName) != $request->code) {
            return ErrorResponse::sendErrorResponse('Код недействителен');
        }

        session()->forget($valueName);

        return $next($request);
    }
}
