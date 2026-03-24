<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\UnauthorizedException as SpatieUnauthorized;
use Illuminate\Http\RedirectResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [];

    public function register(): void
    {
        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage() ?: 'This action is unauthorized.'], 403);
            }

            return redirect()->route('dashboard')->with('error', 'You are not authorized to access that resource.');
        });

        $this->renderable(function (SpatieUnauthorized $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage() ?: 'Unauthorized.'], 403);
            }

            return redirect()->route('dashboard')->with('error', 'Access denied.');
        });

        $this->reportable(function (Throwable $e) {
            // Keep default reporting
        });
    }
}
