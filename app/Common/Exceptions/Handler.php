<?php

namespace App\Common\Exceptions;

use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            $model = class_basename($exception->getModel());

            return response()->json(['message' => "could not find $model matching these ids " . implode(',', $exception->getIds())], 404);
        }
        if ($exception instanceof UnauthorizedHttpException && $request->wantsJson()) {
            return response()->json(['message' => $exception->getMessage()], $exception->getStatusCode());

        }
        if ($exception instanceof ValidationException && $request->wantsJson()) {

            return response()->json(['message' => $exception->getMessage()], 422);

        }
        if ($exception instanceof QueryException && $request->wantsJson()) {
            return response()->json(['message' => $exception->getMessage()], 400);

        }
        if ($exception instanceof \Exception && $request->wantsJson()) {

            return response()->json(['message' => $exception->getMessage()], $exception->getCode() > 100 ? $exception->getCode() : 200);

        }

        return parent::render($request, $exception);
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
}
