<?php

namespace App\Repositories\Transaction;

interface TransactionRepositoryInterface
{
    public function transfer(array $params);
    public function checkServiceAuthorization();
    public function notificationTransferCompleted();
}
