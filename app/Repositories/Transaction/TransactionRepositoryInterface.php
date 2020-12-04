<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function transfer(array $params): Transaction;
    public function checkServiceAuthorization(): bool;
    public function notificationTransferCompleted(): bool;
}
