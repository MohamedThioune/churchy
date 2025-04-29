<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Workship;

class WorkshipApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_workship()
    {
        $workship = Workship::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/workships', $workship
        );

        $this->assertApiResponse($workship);
    }

    /**
     * @test
     */
    public function test_read_workship()
    {
        $workship = Workship::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/workships/'.$workship->id
        );

        $this->assertApiResponse($workship->toArray());
    }

    /**
     * @test
     */
    public function test_update_workship()
    {
        $workship = Workship::factory()->create();
        $editedWorkship = Workship::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/workships/'.$workship->id,
            $editedWorkship
        );

        $this->assertApiResponse($editedWorkship);
    }

    /**
     * @test
     */
    public function test_delete_workship()
    {
        $workship = Workship::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/workships/'.$workship->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/workships/'.$workship->id
        );

        $this->response->assertStatus(404);
    }
}
