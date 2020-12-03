<?php

namespace App\Services\Transaction;

interface TransactionServiceInterface
{
    public function execute(array $params);
}
