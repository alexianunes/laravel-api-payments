<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use App\Models\User;
use Exception;
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
     * Tests the expected exception of the verification method if the user type can perform a transfer
     *
     * @return void
     */
    public function testExpectedExceptionCheckAuthorizationUserTransfer()
    {
        $this->expectException(Exception::class);

        $userCommon = factory(User::class)->create([
            'type' => 2
        ]);
        
        $action = app(UserRepositoryInterface::class)->checkAuthorizationUser($userCommon->id);
    }

    /**
     * Tests the method of adding balance to the user
     *
     * @return void
     */
    public function testAddBalance()
    {
        $balance = 20.00;

        $userCommon = factory(User::class)->create();
        $action = app(UserRepositoryInterface::class)->addBalance($userCommon->id, $balance);

        $this->assertTrue($action);
        $this->assertDatabaseHas('users', [
            'balance_wallet' => $balance
        ]);
    }

    /**
     * Tests an expected exception of the method of adding balance to the user
     *
     * @return void
     */
    public function testExpectedExceptionAddBalance()
    {
        $this->expectException(Exception::class);
        $balance = 20.00;

        $userCommon = factory(User::class)->create();
        $action = app(UserRepositoryInterface::class)->addBalance(2, $balance);
    }

    /**
     * Tests the method of subtracting the user's balance
     *
     * @return void
     */
    public function testSubtractBalance()
    {
        $balance = 50.00;
        $subtract_balance = 10.00;
        $balance_wallet_expected = $balance - $subtract_balance;

        $userCommon = factory(User::class)->create([
            'balance_wallet' => $balance
        ]);
        $action = app(UserRepositoryInterface::class)->subtractBalance($userCommon->id, $subtract_balance);

        $this->assertTrue($action);
        $this->assertDatabaseHas('users', [
            'balance_wallet' => $balance_wallet_expected
        ]);
    }

    /**
     * Tests the expected exception of the method of subtracting the user's balance
     *
     * @return void
     */
    public function testExpectedExceptionSubtractBalance()
    {
        $this->expectException(Exception::class);

        $subtract_balance = 100.00;

        $userCommon = factory(User::class)->create([
            'balance_wallet' => 50.00
        ]);
        $action = app(UserRepositoryInterface::class)->subtractBalance($userCommon->id, $subtract_balance);
    }
}
