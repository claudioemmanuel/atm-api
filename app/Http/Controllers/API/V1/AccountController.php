<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccountController extends Controller
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
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRequest $request)
    {
        try {

            return response([
                'data'  => new AccountResource(
                    $this->accountRepository->create($request->all())
                )
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {

            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
