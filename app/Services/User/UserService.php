<?php

namespace App\Services\Transaction;

use Model\User;

class UserService implements UserServiceInterface
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
