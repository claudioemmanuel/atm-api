<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DepositJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The transaction instance.
     *
     * @var Request $request
     */
    protected $request;

    /**
     * Create a new job instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user_account = $this->request['user_account'];

        DB::transaction(function () use ($user_account) {

            Transaction::create([
                'account_id'            => $user_account->id,
                'user_id'               => $user_account->user_id,
                'transaction_type_id'   => 2,
                'amount'                => $this->request['amount']
            ]);

            $user_account->balance += $this->request['amount'];
            $user_account->save();
        });
    }
}
