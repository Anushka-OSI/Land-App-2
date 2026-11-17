<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
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
        $this->reportable(function (Throwable $e) {
            //
        });

        // Uploads bigger than PHP's post_max_size (e.g. many large event photos at once):
        // go back to the form with a message instead of a "413 Post Too Large" error page.
        // The session hasn't started at this point, so the message is passed in the URL.
        $this->renderable(function (PostTooLargeException $e, $request) {
            $back = $request->headers->get('referer');

            if (!$back || !str_starts_with($back, url('/admin'))) {
                return null;
            }

            $back = preg_replace('/([?&])upload_too_large=1(&|$)/', '$1', $back);
            $separator = str_contains($back, '?') ? '&' : '?';

            return redirect()->to(rtrim($back, '?&') . $separator . 'upload_too_large=1');
        });
    }
}
