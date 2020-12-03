<?php

namespace Tests\Unit\Transaction;

use Tests\TestCase;
use App\Models\User;
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

        $payer = factory(User::class)->create([
            'document' => '70687778050',
            'balance_wallet' => 200.00
        ]);

        $payee = factory(User::class)->create([
            'document' => '00057527000152',
            'balance_wallet' => 100.00,
            'type' => 2
        ]);

        $response = $this->postJson('/api/transaction', [
            "value" => 50.00,
            "payee" => $payee->id,
            "payer" => $payer->id
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "data" => "Transfer successful."
        ]);
        
        $this->assertEquals(150.00, $payer->fresh()->balance_wallet);
        $this->assertEquals(150.00, $payee->fresh()->balance_wallet);
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
