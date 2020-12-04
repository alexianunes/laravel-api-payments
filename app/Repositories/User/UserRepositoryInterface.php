<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function find(int $user_id): User;
    public function checkAuthorizationUser(int $user_id): bool;
    public function addBalance(int $user_id, float $value): bool;
    public function subtractBalance(int $user_id, float $value): bool;
}
