<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        QueryException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
        QueryException::class
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        
    }

    public function render($request, Throwable $e){
      if($e instanceof QueryException){
        return response()->json([
          "status" => false,
          "body" => [
            "message" => $e->getMessage()
          ]
        ], 500);
      }
      return parent::render($request, $e);
    }
}
