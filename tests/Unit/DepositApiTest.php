<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Deposit;
use Illuminate\Support\Facades\Log;

class DepositApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_deposit()
    {
        $deposit = Deposit::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/deposits', $deposit
        );

        $this->assertApiResponse($deposit);
    }

    /**
     * @test
     */
    public function test_read_deposit()
    {
        $deposit = Deposit::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/deposits/'.$deposit->id
        );

        $this->assertApiResponse($deposit->toArray());
    }

    /**
     * @test
     */
    public function test_update_deposit()
    {
        $deposit = Deposit::factory()->create();
        $editedDeposit = Deposit::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/deposits/'.$deposit->id,
            $editedDeposit
        );

        $this->assertApiResponse($editedDeposit);
    }

    /**
     * @test
     */
    public function test_delete_deposit()
    {
        $deposit = Deposit::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/deposits/'.$deposit->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/deposits/'.$deposit->id
        );

        $this->response->assertStatus(404);
    }
}
