<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tithe;

class TitheApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tithe()
    {
        $tithe = Tithe::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/tithes', $tithe
        );

        $this->assertApiResponse($tithe);
    }

    /**
     * @test
     */
    public function test_read_tithe()
    {
        $tithe = Tithe::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/tithes/'.$tithe->id
        );

        $this->assertApiResponse($tithe->toArray());
    }

    /**
     * @test
     */
    public function test_update_tithe()
    {
        $tithe = Tithe::factory()->create();
        $editedTithe = Tithe::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/tithes/'.$tithe->id,
            $editedTithe
        );

        $this->assertApiResponse($editedTithe);
    }

    /**
     * @test
     */
    public function test_delete_tithe()
    {
        $tithe = Tithe::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/tithes/'.$tithe->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/tithes/'.$tithe->id
        );

        $this->response->assertStatus(404);
    }
}
