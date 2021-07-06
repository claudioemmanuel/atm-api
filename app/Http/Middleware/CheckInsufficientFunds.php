<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckInsufficientFunds
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->amount > $request->user_account['balance']) {
            return response([
                'message'  => 'Saldo insuficiente para esta transação.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
