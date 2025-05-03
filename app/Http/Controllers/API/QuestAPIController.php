<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateQuestAPIRequest;
use App\Http\Requests\API\UpdateQuestAPIRequest;
use App\Models\Quest;
use App\Models\User;
use App\Models\Settlement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\QuestResource;
use DB;

/**
 * Class QuestController
 */

class QuestAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/quests",
     *      summary="getQuestList",
     *      tags={"Quest"},
     *      description="Get all Quests",
     *      security={{"passport":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Quest")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Quest::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $quests = $query->get();

        return $this->sendResponse(QuestResource::collection($quests), 'Quests retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/quests",
     *      summary="createQuest",
     *      tags={"Quest"},
     *      description="Create Quest",
     *      security={{"passport":{}}},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Quest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Quest"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateQuestAPIRequest $request): JsonResponse
    {
        $input = $request->only(['amount', 'type', 'location', 'ceremony', 'dated_at']);

        /** @var Quest $quest */
        $quest = Quest::create($input);

        //users settlements
        $users = $request->has('user_ids') ? $request->get('user_ids') : [];
        foreach($users as $id):
            $user = User::find($id);
            if (empty($user))
                continue;

            if (!$user->settlements->contains('quest_id', $quest->id)) 
                // $user->settlements()->create(['quest_id', $quest->id]);
                Settlement::create(['quest_id' => $quest->id, 'user_id' => $user->id]);
        endforeach;

        return $this->sendResponse(new QuestResource($quest), 'Quest saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/quests/{id}",
     *      summary="getQuestItem",
     *      tags={"Quest"},
     *      description="Get Quest",
     *      security={{"passport":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Quest",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Quest"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Quest $quest */
        $quest = Quest::find($id);

        if (empty($quest)) {
            return $this->sendError('Quest not found');
        }

        return $this->sendResponse(new QuestResource($quest), 'Quest retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/quests/{id}",
     *      summary="updateQuest",
     *      tags={"Quest"},
     *      description="Update Quest",
     *      security={{"passport":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Quest",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Quest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Quest"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateQuestAPIRequest $request): JsonResponse
    {
        /** @var Quest $quest */
        $quest = Quest::find($id);

        if (empty($quest)) {
            return $this->sendError('Quest not found');
        }
        $quest->fill($request->all());
        $quest->save();

        //users settlements
        $users = $request->has('users') ? $request->get('users') : [];
        if (!empty($users))
            Settlement::where('quest_id', $id)->delete();

        foreach($users as $id):
            $user = User::find($id);
            if (empty($user))
                continue;

            if (!$user->settlements->contains('quest_id', $id)) 
                $user->settlements()->create(['quest_id', $id]);
        endforeach;

        return $this->sendResponse(new QuestResource($quest), 'Quest updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/quests/{id}",
     *      summary="deleteQuest",
     *      tags={"Quest"},
     *      description="Delete Quest",
     *      security={{"passport":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Quest",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Quest $quest */
        $quest = Quest::find($id);

        if (empty($quest)) {
            return $this->sendError('Quest not found');
        }

        $quest->delete();

        return $this->sendSuccess('Quest deleted successfully');
    }
}
