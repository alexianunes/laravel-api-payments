<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\TransactionRequest;
use App\Services\Transaction\TransactionServiceInterface;

class TransactionController extends Controller
{
    public function __invoke(TransactionRequest $request, TransactionServiceInterface $transaction)
    {
        $payload = [
            'payer_id' => $request->get('payer'),
            'payee_id' => $request->get('payee'),
            'value' => $request->get('value')
        ];

        
        $transaction->execute($payload);

        return response()->json(['data' => "Transfer successful."], 200);
    }
}
