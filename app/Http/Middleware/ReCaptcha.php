<?php

namespace App\Http\Middleware;

use App\Support\Traits\SendResponseTrait;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReCaptcha
{
    use SendResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|JsonResponse
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

        return $this->sendErrorResponse(['Ошибка ReCaptcha']);
    }
}
