<?php

namespace App\Exceptions;

use App\Traits\SendResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use SendResponseTrait;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(fn (NotFoundHttpException $e, $request) => $this->isJson($request)
            ? $this->sendErrorResponse(['Страница не существует'], 404)
            : null
        );

        $this->renderable(fn (ValidationException $e, Request $request) => $this->isJson($request)
            ? $this->sendErrorResponse($e->validator->errors()->toArray())
            : null
        );

        $this->renderable(fn (AuthenticationException $e, Request $request) => $this->isJson($request)
            ? $this->sendErrorResponse(['Пользователь не аутентифицирован'], 401)
            : null
        );

        $this->renderable(fn (AccessDeniedHttpException $e, Request $request) => $this->isJson($request)
            ? $this->sendErrorResponse(['Недостаточно прав'], 403)
            : null
        );

        $this->renderable(fn (ThrottleRequestsException $e, Request $request) => $this->isJson($request)
            ? $this->sendErrorResponse(['Слишком много запросов'], 429)
            : null
        );
    }

    protected function isJson(Request $request): bool
    {
        return $request->wantsJson() || $request->ajax();
    }
}
