<?php

namespace App\Repositories;

use App\Jobs\DepositJob;
use App\Jobs\WithdrawJob;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class TransactionRepository
{
    /**
     * The transaction model implementation.
     * 
     * @var Transaction;
     */
    protected $model;

    /**
     * TransactionRepository constructor.
     *
     * @param App\Models\Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }

    /**
     * Create deposit transaction
     *
     * @param array $request
     * @return void
     */
    public function createDepositTransaction(array $request)
    {
        DepositJob::dispatch($request, $this->model);
    }

    /**
     * Create withdraw transaction
     *
     * @param array $request
     * @return void
     */
    public function createWithdrawTransaction(array $request)
    {
        $response = array();
        $rest = $request['amount'];

        foreach ($this->model::AVAILABLE_NOTES as $key => $note) {
            $response[$note] = intdiv($rest, $note);
            $rest = $rest % $note;
        }

        if ($rest) {
            return;
        }

        WithdrawJob::dispatch($request, $this->model);

        return $response;
    }

    /**
     * Display bank statement
     *
     * @param Type $var
     * @return void
     */
    public function getBankStatement(array $request)
    {
        if (isset($request['start_date'])) {
            $request['start_date'] = Carbon::createFromFormat('d/m/Y', $request['start_date'], 'America/Sao_Paulo')->format('Y-m-d');
        }

        if (isset($request['end_date'])) {
            $request['end_date'] = Carbon::createFromFormat('d/m/Y', $request['end_date'], 'America/Sao_Paulo')->format('Y-m-d');
        }

        $name = $request['bank_number'] . '_' . $request['account_number'] . '_' . $request['start_date'] . '_' . $request['end_date'];

        if (isset($request['transaction_type_id'])) {
            $name = $request['transaction_type_id'] . '_' . $name;
        }

        return Cache::remember($name, Carbon::now()->addMinutes(10), function () use ($request) {
            return $this->model
                ->where('account_id', $request['account_id'])
                ->when(isset($request['transaction_type_id']), function ($param) use ($request) {
                    $param->where('transaction_type_id', $request['transaction_type_id']);
                })
                ->when(isset($request['start_date']), function ($param) use ($request) {
                    $param->whereDate('created_at', '>=', $request['start_date']);
                })
                ->when(isset($request['end_date']), function ($param) use ($request) {
                    $param->whereDate('created_at', '<=', $request['end_date']);
                })
                ->get();
        });
    }
}
