<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Quest;

class QuestApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_quest()
    {
        $quest = Quest::factory()->make()->toArray();
        $quest['user_ids'] = [2, 3, 4];

        $this->response = $this->json(
            'POST',
            '/api/quests', $quest
        );

        $this->assertApiResponse($quest);
    }

    /**
     * @test
     */
    public function test_read_quest()
    {
        $quest = Quest::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/quests/'.$quest->id
        );

        $this->assertApiResponse($quest->toArray());
    }

    /**
     * @test
     */
    public function test_update_quest()
    {
        $quest = Quest::factory()->create();
        $editedQuest = Quest::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/quests/'.$quest->id,
            $editedQuest
        );

        $this->assertApiResponse($editedQuest);
    }

    /**
     * @test
     */
    public function test_delete_quest()
    {
        $quest = Quest::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/quests/'.$quest->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/quests/'.$quest->id
        );

        $this->response->assertStatus(404);
    }
}
