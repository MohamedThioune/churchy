<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWorkshipAPIRequest;
use App\Http\Requests\API\UpdateWorkshipAPIRequest;
use App\Models\Workship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\WorkshipResource;

/**
 * Class WorkshipController
 */

class WorkshipAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/workships",
     *      summary="getWorkshipList",
     *      tags={"Workship"},
     *      description="Get all Workships",
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
     *                  @OA\Items(ref="#/components/schemas/Workship")
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
        $query = Workship::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $workships = $query->get();

        return $this->sendResponse(WorkshipResource::collection($workships), 'Workships retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/workships",
     *      summary="createWorkship",
     *      tags={"Workship"},
     *      description="Create Workship",
     *      security={{"passport":{}}},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Workship")
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
     *                  ref="#/components/schemas/Workship"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateWorkshipAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Workship $workship */
        $workship = Workship::create($input);

        return $this->sendResponse(new WorkshipResource($workship), 'Workship saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/workships/{id}",
     *      summary="getWorkshipItem",
     *      tags={"Workship"},
     *      description="Get Workship",
     *      security={{"passport":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Workship",
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
     *                  ref="#/components/schemas/Workship"
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
        /** @var Workship $workship */
        $workship = Workship::find($id);

        if (empty($workship)) {
            return $this->sendError('Workship not found');
        }

        return $this->sendResponse(new WorkshipResource($workship), 'Workship retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/workships/{id}",
     *      summary="updateWorkship",
     *      tags={"Workship"},
     *      description="Update Workship",
     *      security={{"passport":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Workship",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Workship")
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
     *                  ref="#/components/schemas/Workship"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateWorkshipAPIRequest $request): JsonResponse
    {
        /** @var Workship $workship */
        $workship = Workship::find($id);

        if (empty($workship)) {
            return $this->sendError('Workship not found');
        }

        $workship->fill($request->all());
        $workship->save();

        return $this->sendResponse(new WorkshipResource($workship), 'Workship updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/workships/{id}",
     *      summary="deleteWorkship",
     *      tags={"Workship"},
     *      description="Delete Workship",
     *      security={{"passport":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Workship",
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
        /** @var Workship $workship */
        $workship = Workship::find($id);

        if (empty($workship)) {
            return $this->sendError('Workship not found');
        }

        $workship->delete();

        return $this->sendSuccess('Workship deleted successfully');
    }
}
