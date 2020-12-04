<?php

namespace Tests\Unit\Transaction;

use Exception;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Transaction\TransactionRepositoryInterface;

class TransactionTest extends TestCase
{

    use RefreshDatabase;
    
    /**
     * Tests the transfer action per post
     *
     * @return void
     */
    public function testTransfer()
    {

        $balance_initial_payer = 200.00;
        $balance_initial_payee = 100.00;
        $value_transfer = 50.00;

        $expected_balance_payer = $balance_initial_payer - $value_transfer;
        $expected_balance_payee = $balance_initial_payee + $value_transfer;

        $payer = factory(User::class)->create([
            'document' => '70687778050',
            'balance_wallet' => $balance_initial_payer
        ]);

        
        $payee = factory(User::class)->create([
            'document' => '00057527000152',
            'balance_wallet' => $balance_initial_payee,
            'type' => 2
        ]);

        $response = $this->postJson('/api/transaction', [
            "value" => $value_transfer,
            "payee" => $payee->id,
            "payer" => $payer->id
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "data" => "Transfer successful."
        ]);
        
        $this->assertEquals($expected_balance_payer, $payer->fresh()->balance_wallet);
        $this->assertEquals($expected_balance_payee, $payee->fresh()->balance_wallet);

        $this->assertDatabaseHas('transactions', [
            'payee_id' => $payee->id,
            'payer_id' => $payer->id,
            'value' => $value_transfer
        ]);
    }

    /**
     * Tests the expected exception of the transfer post with the shopkeeper user
     *
     * @return void
     */
    public function testExpectedExceptionTransferShopkeeperUser()
    {
        $balance_initial_payer = 200.00;
        $balance_initial_payee = 100.00;
        $value_transfer = 50.00;

        $expected_balance_payer = $balance_initial_payer - $value_transfer;
        $expected_balance_payee = $balance_initial_payee + $value_transfer;

        $payer = factory(User::class)->create([
            'document' => '10057527000154',
            'balance_wallet' => $balance_initial_payer,
            'type' => 2
        ]);

        
        $payee = factory(User::class)->create([
            'document' => '30687778054',
            'balance_wallet' => $balance_initial_payee,
            'type' => 1
        ]);

        $response = $this->postJson('/api/transaction', [
            "value" => $value_transfer,
            "payee" => $payee->id,
            "payer" => $payer->id
        ]);

        $response->assertStatus(500);
        $this->assertEquals("Shopkeepers cannot carry out transactions", Arr::get(
            $response->decodeResponseJson(),
            'message'
        ));
        $this->assertEquals($balance_initial_payer, $payer->fresh()->balance_wallet);
        $this->assertEquals($balance_initial_payee, $payee->fresh()->balance_wallet);

        $this->assertDatabaseMissing('transactions', [
            'payee_id' => $payee->id,
            'payer_id' => $payer->id,
            'value' => $value_transfer
        ]);
    }

    /**
     * Tests the expected exception of the transfer post with the user without a balance
     *
     * @return void
     */
    public function testExpectedExceptionTransferUserWithoutBalance()
    {
        $balance_initial_payer = 200.00;
        $balance_initial_payee = 100.00;
        $value_transfer = 300.00;

        $expected_balance_payer = $balance_initial_payer - $value_transfer;
        $expected_balance_payee = $balance_initial_payee + $value_transfer;

        $payer = factory(User::class)->create([
            'document' => '24687778080',
            'balance_wallet' => $balance_initial_payer
        ]);

        
        $payee = factory(User::class)->create([
            'document' => '79037527000152',
            'balance_wallet' => $balance_initial_payee,
            'type' => 2
        ]);

        $response = $this->postJson('/api/transaction', [
            "value" => $value_transfer,
            "payee" => $payee->id,
            "payer" => $payer->id
        ]);

        $response->assertStatus(500);
        $this->assertEquals("Insufficient funds.", Arr::get(
            $response->decodeResponseJson(),
            'message'
        ));
        $this->assertEquals($balance_initial_payer, $payer->fresh()->balance_wallet);
        $this->assertEquals($balance_initial_payee, $payee->fresh()->balance_wallet);

        $this->assertDatabaseMissing('transactions', [
            'payee_id' => $payee->id,
            'payer_id' => $payer->id,
            'value' => $value_transfer
        ]);
    }

    /**
     * Tests the service authorization check method
     *
     * @return void
     */
    public function testCheckServiceAuthorization()
    {
        $action = app(TransactionRepositoryInterface::class)->checkServiceAuthorization();
        $this->assertTrue($action);
    }

    /**
     * Tests the completed transfer notification method
     *
     * @return void
     */
    public function testNotificationTransferCompleted()
    {
        $action = app(TransactionRepositoryInterface::class)->notificationTransferCompleted();
        $this->assertTrue($action);
    }
}
