<?php

namespace App\Services\Transaction;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;

class TransactionService implements TransactionServiceInterface
{

    private $transactionRepository;
    private $userRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository, UserRepositoryInterface $userRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Validates information and transfers between users
     *
     * @param array $params
     * @return boolean
     */
    public function execute(array $params)
    {
        DB::beginTransaction();
        
        try {
            $this->userRepository->checkAuthorizationUser($params['payer_id']);
            $this->transactionRepository->checkServiceAuthorization();
            $this->transactionRepository->transfer($params);
            $this->userRepository->addBalance($params['payee_id'], $params['value']);
            $this->userRepository->subtractBalance($params['payer_id'], $params['value']);
            $this->transactionRepository->notificationTransferCompleted();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
        }

        return false;
    }
}
