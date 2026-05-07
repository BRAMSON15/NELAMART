<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FixCookieForNgrok
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Fix cookies for ngrok by ensuring they work with HTTPS proxy
        if ($request->secure() || $request->header('X-Forwarded-Proto') === 'https') {
            // Get all cookies from response
            $cookies = $response->headers->getCookies();
            
            foreach ($cookies as $cookie) {
                // Recreate cookie with SameSite=None and Secure for HTTPS
                $response->headers->setCookie(
                    cookie(
                        $cookie->getName(),
                        $cookie->getValue(),
                        $cookie->getExpiresTime(),
                        $cookie->getPath(),
                        $cookie->getDomain(),
                        true, // secure
                        $cookie->isHttpOnly(),
                        false, // raw
                        $cookie->getSameSite() ?: 'none'
                    )
                );
            }
        }
        
        return $response;
    }
}
