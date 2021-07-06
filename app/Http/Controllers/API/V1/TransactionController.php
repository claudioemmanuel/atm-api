<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExtractRequest;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * The transaction repository implementation.
     *
     * @var TransactionRepository
     */
    protected $transactionRepository;

    /**
     * Create a new controller instance.
     *
     * @param App\Repositories\TransactionRepository $transactionRepository
     * @return void
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Deposit operation
     *
     * @param Request $request
     * @return void
     */
    public function deposit(TransactionRequest $request)
    {
        try {

            $this->transactionRepository->createDepositTransaction($request->all());

            return response([
                'message'  => 'Transação enviada com sucesso, verifique seu novo saldo.'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {

            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Withdraw operation
     *
     * @param Request $request
     * @return void
     */
    public function withdraw(TransactionRequest $request)
    {
        try {

            $response = $this->transactionRepository->createWithdrawTransaction($request->all());

            if ($response) {
                return response([
                    'message'  => 'Transação enviada com sucesso, verifique seu novo saldo.',
                    'data'  => $response
                ], Response::HTTP_CREATED);
            } else {
                return response([
                    'message'  => 'Notas disponíveis: 100, 50 e 20. Insira um valor válido para saque.'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {

            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display account statement
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function extract(ExtractRequest $request)
    {
        try {

            return response([
                'data' => TransactionResource::collection(
                    $this->transactionRepository->getBankStatement($request->all())
                )
            ], Response::HTTP_OK);
        } catch (\Exception $e) {

            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
