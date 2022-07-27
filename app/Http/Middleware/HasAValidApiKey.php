<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasAValidApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('apiKey')) {

            $user = User::where('token', $request->header('apiKey'))
                ->first();

            if ($user) {
                // check if token exist and can send email
                $request->merge(['user' => $user]);

                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorised'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
