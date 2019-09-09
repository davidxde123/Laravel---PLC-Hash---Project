<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Request;
use Illuminate\Auth\AuthenticationException;
use Response;
use App\GeneralFunction;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
 
    public function render($request, Exception $exception)
            {
                if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
                     $dump_response= GeneralFunction::generalErrors("error","Acceso",403, "Metodo - Api","Acceso Denegado");

                      return response()->json($dump_response, $dump_response["code"]);
                }

                return parent::render($request, $exception);
    }
    


    protected function unauthenticated($request, AuthenticationException $exception)
         {

            $dump_response= GeneralFunction::generalErrors("error","Acceso",403, "Api","Token Api Invalido");

            return response()->json($dump_response, $dump_response["code"]);
         }
}
