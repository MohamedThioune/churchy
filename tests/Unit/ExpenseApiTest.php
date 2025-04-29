<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Expense;

class ExpenseApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_expense()
    {
        $expense = Expense::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/expenses', $expense
        );

        $this->assertApiResponse($expense);
    }

    /**
     * @test
     */
    public function test_read_expense()
    {
        $expense = Expense::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/expenses/'.$expense->id
        );

        $this->assertApiResponse($expense->toArray());
    }

    /**
     * @test
     */
    public function test_update_expense()
    {
        $expense = Expense::factory()->create();
        $editedExpense = Expense::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/expenses/'.$expense->id,
            $editedExpense
        );

        $this->assertApiResponse($editedExpense);
    }

    /**
     * @test
     */
    public function test_delete_expense()
    {
        $expense = Expense::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/expenses/'.$expense->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/expenses/'.$expense->id
        );

        $this->response->assertStatus(404);
    }
}
