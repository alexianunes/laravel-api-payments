<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function checkAuthorizationUser(int $user_id);
    public function addBalance(int $user_id, float $value);
    public function subtractBalance(int $user_id, float $value);
}
