<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }
    
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // if ($this->isHttpException($exception)) {
        //     switch ($exception->getStatusCode()) {
        //         case 403:
        //             return response()->view('pages-403', [], 403);
        //         break;
        //         case 404:
        //             return response()->view('pages-404', [], 404);
        //         break;
        //         case 419:
        //             return response()->view('pages-419', [], 419);
        //         break;
        //         case 500:
        //             return response()->view('pages-500', [], 500);
        //         break;
        //     }
        // }
        
        return parent::render($request, $exception);
    }
}
