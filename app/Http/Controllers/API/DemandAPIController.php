<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDemandAPIRequest;
use App\Http\Requests\API\UpdateDemandAPIRequest;
use App\Models\Demand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DemandResource;

/**
 * Class DemandController
 */

class DemandAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/demands",
     *      summary="getDemandList",
     *      tags={"Demand"},
     *      description="Get all Demands",
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
     *                  @OA\Items(ref="#/components/schemas/Demand")
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
        $query = Demand::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $demands = $query->get();

        return $this->sendResponse(DemandResource::collection($demands), 'Demands retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/demands",
     *      summary="createDemand",
     *      tags={"Demand"},
     *      description="Create Demand",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Demand")
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
     *                  ref="#/components/schemas/Demand"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDemandAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Demand $demand */
        $demand = Demand::create($input);

        return $this->sendResponse(new DemandResource($demand), 'Demand saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/demands/{id}",
     *      summary="getDemandItem",
     *      tags={"Demand"},
     *      description="Get Demand",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Demand",
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
     *                  ref="#/components/schemas/Demand"
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
        /** @var Demand $demand */
        $demand = Demand::find($id);

        if (empty($demand)) {
            return $this->sendError('Demand not found');
        }

        return $this->sendResponse(new DemandResource($demand), 'Demand retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/demands/{id}",
     *      summary="updateDemand",
     *      tags={"Demand"},
     *      description="Update Demand",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Demand",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Demand")
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
     *                  ref="#/components/schemas/Demand"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDemandAPIRequest $request): JsonResponse
    {
        /** @var Demand $demand */
        $demand = Demand::find($id);

        if (empty($demand)) {
            return $this->sendError('Demand not found');
        }

        $demand->fill($request->all());
        $demand->save();

        return $this->sendResponse(new DemandResource($demand), 'Demand updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/demands/{id}",
     *      summary="deleteDemand",
     *      tags={"Demand"},
     *      description="Delete Demand",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Demand",
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
        /** @var Demand $demand */
        $demand = Demand::find($id);

        if (empty($demand)) {
            return $this->sendError('Demand not found');
        }

        $demand->delete();

        return $this->sendSuccess('Demand deleted successfully');
    }
}
