<?php
//editan baru
namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // Menambahkan header CORS
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}