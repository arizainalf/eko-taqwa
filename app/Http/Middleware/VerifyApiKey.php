<?php
namespace App\Http\Middleware;

use App\Traits\ApiResponder;
use Closure;
use Illuminate\Http\Request;

class VerifyApiKey
{
    use ApiResponder;
    public function handle(Request $request, Closure $next)
    {
        $apiKey   = $request->header('X-API-KEY');
        $validKey = env('PUBLIC_API_KEY', 'defaultkey123'); // set di .env

        if ($apiKey !== $validKey) {
            return $this->unauthorizedResponse('');
        }

        return $next($request);
    }
}
