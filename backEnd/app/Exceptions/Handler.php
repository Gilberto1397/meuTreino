<?php

namespace App\Exceptions;

use DomainException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (DomainException $exception, $request) {
            if ($exception->getMessage() === 'Faça login para continuar!') {
                return response()->json([
                    'message' => $exception->getMessage(),
                    'error' => true,
                ], $exception->getCode());
            }
        });

        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'messages' => $e->errors(),
                'error' => $e->getResponse()->original['error'],
            ], 406);
        });

        $this->renderable(function (\Throwable $exception, $request) {
//            Log::channel('errors')
//                ->warning(
//                    'ERRO NÃO TRATADO',
//                    [
//                        'ExceptionType' => get_class($exception),
//                        'errorMessage' => $exception->getMessage(),
//                        'file' => $exception->getFile(),
//                        'line' => $exception->getLine()
//                    ]
//                );

            return response()->json([
                'message' => 'Ooops, parece que houve um erro. Contate o suporte!',
                'error' => true,
            ], 500);
        });
    }
}
