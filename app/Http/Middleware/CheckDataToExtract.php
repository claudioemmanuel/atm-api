<?php

namespace App\Http\Middleware;

use App\Repositories\AccountRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckDataToExtract
{
    /**
     * The account repository implementation.
     *
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * Create a new controller instance.
     *
     * @param App\Repositories\AccountRepository $accountRepository
     * @return void
     */
    public function __construct(
        AccountRepository $accountRepository
    ) {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user_account = $this->accountRepository->findByParams($request->all());

        if ($user_account) {

            $request->merge([
                'account_id' => $user_account->id
            ]);

            return $next($request);
        } else {
            return response([
                'message'   => 'Conta do usuário incorreta, favor verificar.'
            ], Response::HTTP_NOT_FOUND);
        }
        return $next($request);
    }
}
