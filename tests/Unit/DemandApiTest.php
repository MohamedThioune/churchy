<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Demand;

class DemandApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_demand()
    {
        $demand = Demand::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/demands', $demand
        );

        $this->assertApiResponse($demand);
    }

    /**
     * @test
     */
    public function test_read_demand()
    {
        $demand = Demand::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/demands/'.$demand->id
        );

        $this->assertApiResponse($demand->toArray());
    }

    /**
     * @test
     */
    public function test_update_demand()
    {
        $demand = Demand::factory()->create();
        $editedDemand = Demand::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/demands/'.$demand->id,
            $editedDemand
        );

        $this->assertApiResponse($editedDemand);
    }

    /**
     * @test
     */
    public function test_delete_demand()
    {
        $demand = Demand::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/demands/'.$demand->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/demands/'.$demand->id
        );

        $this->response->assertStatus(404);
    }
}
