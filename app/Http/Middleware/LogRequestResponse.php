<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class LogRequestResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current route name and controller action
        $controllerAction = Route::currentRouteAction(); // Get the controller and method name

        $method = $request->method(); // Get the request method (GET, POST, etc.)
        
        // Log request info
        Log::info("Request Info : Route : $controllerAction, Method: $method, Request Data: " . json_encode($request->all()));

        // Pass the request to the next middleware or controller
        $response = $next($request);

        // Check if the response is a JsonResponse
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            Log::info("Response Info : Route : $controllerAction, Status: {$response->status()}, Response Data: " . json_encode($response->getData()));
        } else {
            Log::info("Response Info : Route : $controllerAction, Response Data: " . $response->getContent());
        }

        return $response;
    }
}
