<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReCaptcha
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
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->recaptcha,
                'ip' => $request->ip()
            ]
        );

        if ($response->json('success') && $response->json('score') > config('services.recaptcha.min_score')) {
            return $next($request);
        }

        return response()->json(
            [
                'errors' => [
                    'message' => 'Ошибка ReCaptcha'
                ]
            ],
            422
        );
    }
}
