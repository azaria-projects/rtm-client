<?php

namespace App\Http\Middleware;

use Cookie;
use Closure;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $tkn = trim($_COOKIE['token'] ?? '', '"');
            if ($tkn == '') {
                return redirect()->route('login');
            }

            $url = sprintf('%s/%s/token/%s', getenv('VITE_SERVER_URL'), getenv('VITE_SERVER_PREFIX'), $tkn);
            $res = Http::get($url);
            
            if ($res->ok() & $res['response'] != []) {
                $url = sprintf('%s/%s/token/refresh/%s', getenv('VITE_SERVER_URL'), getenv('VITE_SERVER_PREFIX'), $tkn);
                $ref = Http::post($url);

                if ($res->ok() & $ref['response'] != []) {
                    $_COOKIE['token'] = $ref['response'];
                }

                return $next($request);
            }

            if ($res->ok() & $res['response'] == []) {
                return redirect()
                    ->route('login')
                    ->withCookie(Cookie::forget('token'))
                    ->withCookie(Cookie::forget('well'))
                    ->with('error', 'token expired!');
            }

            return $next($request);

        } catch (Exception $e) {
            return redirect()
                ->route('login')
                ->withCookie(Cookie::forget('token'))
                ->withCookie(Cookie::forget('well'))
                ->with('error', $e->getMessage());
        }
    }
}
