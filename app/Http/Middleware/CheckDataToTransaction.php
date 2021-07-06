<?php

namespace App\Http\Middleware;

use App\Repositories\AccountRepository;
use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckDataToTransaction
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     * @var AccountRepository
     */
    protected $userRepository;
    protected $accountRepository;

    /**
     * Create a new controller instance.
     *
     * @param App\Repositories\UserRepository $userRepository
     * @param App\Repositories\AccountRepository $accountRepository
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        AccountRepository $accountRepository
    ) {
        $this->userRepository = $userRepository;
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
        try {

            $user = $this->userRepository->findByCpf($request->cpf);

            if ($user) {

                $request->merge([
                    'user_id' => $user->id
                ]);

                $user_account = $this->accountRepository->findByParams($request->all());

                if ($user_account) {

                    $request->merge([
                        'user_account' => $user_account
                    ]);

                    return $next($request);
                } else {
                    return response([
                        'message'   => 'Conta do usuário incorreta, favor verificar.'
                    ], Response::HTTP_NOT_FOUND);
                }
            } else {
                return response([
                    'message'   => 'Usuário não encontrado.'
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {

            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
