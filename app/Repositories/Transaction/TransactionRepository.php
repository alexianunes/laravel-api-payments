<?php

namespace App\Repositories\Transaction;

use Exception;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class TransactionRepository implements TransactionRepositoryInterface
{

    private $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    /**
     * Performs tranasfer to the user
     *
     * @param array $params
     * @return App\Models\Transaction
     */
    public function transfer(array $params)
    {
        return $this->model->create($params);
    }

    /**
     * Checks whether the service is authorized
     *
     * @return boolean
     */
    public function checkServiceAuthorization()
    {
        $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');

        if ($response->failed() || Arr::get($response->json(), 'message') !== "Autorizado") {
            throw new Exception("Transaction not authorized!");
        }

        return true;
    }

    /**
     * Notifies the payee of the transaction
     *
     * @return boolean
     */
    public function notificationTransferCompleted()
    {
        $response = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');

        if ($response->failed() || Arr::get($response->json(), 'message') !== "Enviado") {
            return false;
        }

        return true;
    }
}
