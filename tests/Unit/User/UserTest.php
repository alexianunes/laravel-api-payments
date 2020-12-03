<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    use RefreshDatabase;
    
    /**
     * Tests the method of checking whether the user type can perform transfer
     *
     * @return void
     */
    public function testCheckAuthorizationUserTransfer()
    {
        $userCommon = factory(User::class)->create();
        $action = app(UserRepositoryInterface::class)->checkAuthorizationUser($userCommon->id);
        $this->assertTrue($action);
    }

    /**
     * Tests the method of adding balance to the user
     *
     * @return void
     */
    public function testAddBalance()
    {
        $userCommon = factory(User::class)->create();
        $action = app(UserRepositoryInterface::class)->addBalance($userCommon->id, 20.00);
        $this->assertTrue($action);
    }

    /**
     * Tests the method of subtracting the user's balance
     *
     * @return void
     */
    public function testSubtractBalance()
    {
        $userCommon = factory(User::class)->create();
        $action = app(UserRepositoryInterface::class)->addBalance($userCommon->id, 10.00);
        $this->assertTrue($action);
    }

}
