<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    /**
     * The account model implementation.
     * 
     * @var Account;
     */
    protected $model;

    /**
     * AccountRepository constructor.
     *
     * @param App\Models\Account $account
     */
    public function __construct(Account $account)
    {
        $this->model = $account;
    }

    /**
     * Find by params
     *
     * @param array $request
     * @return App\Models\Account
     */
    public function findByParams(array $request)
    {
        return $this->model
            ->when(isset($request['user_id']), function ($param) use ($request) {
                $param->where('user_id', $request['user_id']);
            })
            ->where('bank_number', $request['bank_number'])
            ->where('account_number', $request['account_number'])
            ->first();
    }

    /**
     * Create new account
     *
     * @param array $request
     * @return App\Models\Account
     */
    public function create(array $request)
    {
        return $this->model->create($request);
    }
}
