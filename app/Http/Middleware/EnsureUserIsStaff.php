<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsStaff
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'unauthenticated',
                    'message' => 'Sesi staf telah berakhir. Silakan masuk kembali.',
                ], 401);
            }

            return redirect()->route('staff.login');
        }

        if (! $request->user()->isStaff()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'unauthorized',
                    'message' => 'Anda tidak memiliki hak akses staf untuk fitur ini.',
                ], 403);
            }

            abort(403, 'Akses terbatas untuk staf dan administrator acara.');
        }

        return $next($request);
    }
}
