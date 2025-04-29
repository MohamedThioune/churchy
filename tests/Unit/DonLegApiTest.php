<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\DonLeg;

class DonLegApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_don_leg()
    {
        $donLeg = DonLeg::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/don-legs', $donLeg
        );

        $this->assertApiResponse($donLeg);
    }

    /**
     * @test
     */
    public function test_read_don_leg()
    {
        $donLeg = DonLeg::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/don-legs/'.$donLeg->id
        );

        $this->assertApiResponse($donLeg->toArray());
    }

    /**
     * @test
     */
    public function test_update_don_leg()
    {
        $donLeg = DonLeg::factory()->create();
        $editedDonLeg = DonLeg::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/don-legs/'.$donLeg->id,
            $editedDonLeg
        );

        $this->assertApiResponse($editedDonLeg);
    }

    /**
     * @test
     */
    public function test_delete_don_leg()
    {
        $donLeg = DonLeg::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/don-legs/'.$donLeg->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/don-legs/'.$donLeg->id
        );

        $this->response->assertStatus(404);
    }
}
