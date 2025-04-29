<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Sacrament;
use Illuminate\Support\Facades\Log;

class SacramentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sacrament()
    {
        $sacrament = Sacrament::factory()->make()->toArray();
        $this->response = $this->json(
            'POST',
            '/api/sacraments', $sacrament
        );

        $this->assertApiResponse($sacrament);
    }

    /**
     * @test
     */
    public function test_read_sacrament()
    {
        $sacrament = Sacrament::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/sacraments/'.$sacrament->id
        );

        $this->assertApiResponse($sacrament->toArray());
    }

    /**
     * @test
     */
    public function test_update_sacrament()
    {
        $sacrament = Sacrament::factory()->create();
        $editedSacrament = Sacrament::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sacraments/'.$sacrament->id,
            $editedSacrament
        );

        $this->assertApiResponse($editedSacrament);
    }

    /**
     * @test
     */
    public function test_delete_sacrament()
    {
        $sacrament = Sacrament::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sacraments/'.$sacrament->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sacraments/'.$sacrament->id
        );

        $this->response->assertStatus(404);
    }
}
