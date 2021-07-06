<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckDataToAccount
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $userRepository
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
                    'user_id'           => $user->id,
                    'bank_number'       => rand(1000, 9999),
                    'account_number'    => rand(10000, 99999)
                ]);

                return $next($request);
            } else {
                return response([
                    'message'   => 'Cpf não encontrado.'
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {

            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
