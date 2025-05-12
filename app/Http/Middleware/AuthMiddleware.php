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
                $res = Http::post($url);

                if ($res->ok() & $res['response'] != []) {
                    $_COOKIE['token'] = $res['response'];
                }

                return $next($request);
            }

            if ($res->ok() & $res['response'] != []) {
                $request->cookies->remove('token');
                $cookie = Cookie::forget('token');

                return $next($request);
            }

            return redirect()->route('login')->with('error', 'token expired!');

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'server unavailable! try accessing it later!');
        }
    }
}
