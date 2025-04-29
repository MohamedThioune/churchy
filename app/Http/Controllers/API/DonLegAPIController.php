<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDonLegAPIRequest;
use App\Http\Requests\API\UpdateDonLegAPIRequest;
use App\Models\DonLeg;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DonLegResource;

/**
 * Class DonLegController
 */

class DonLegAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/don-legs",
     *      summary="getDonLegList",
     *      tags={"DonLeg"},
     *      description="Get all DonLegs",
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Bearer token for authentication",
     *           @OA\Schema(
     *             type="string"
     *          ),
     *          required=true,
     *          in="header"
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
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/DonLeg")
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
        $query = DonLeg::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $donLegs = $query->get();

        return $this->sendResponse(DonLegResource::collection($donLegs), 'Don Legs retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/don-legs",
     *      summary="createDonLeg",
     *      tags={"DonLeg"},
     *      description="Create DonLeg",
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Bearer token for authentication",
     *           @OA\Schema(
     *             type="string"
     *          ),
     *          required=true,
     *          in="header"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/DonLeg")
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
     *                  ref="#/components/schemas/DonLeg"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDonLegAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var DonLeg $donLeg */
        $donLeg = DonLeg::create($input);

        return $this->sendResponse(new DonLegResource($donLeg), 'Don Leg saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/don-legs/{id}",
     *      summary="getDonLegItem",
     *      tags={"DonLeg"},
     *      description="Get DonLeg",
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Bearer token for authentication",
     *           @OA\Schema(
     *             type="string"
     *          ),
     *          required=true,
     *          in="header"
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="id of DonLeg",
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
     *                  ref="#/components/schemas/DonLeg"
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
        /** @var DonLeg $donLeg */
        $donLeg = DonLeg::find($id);

        if (empty($donLeg)) {
            return $this->sendError('Don Leg not found');
        }

        return $this->sendResponse(new DonLegResource($donLeg), 'Don Leg retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/don-legs/{id}",
     *      summary="updateDonLeg",
     *      tags={"DonLeg"},
     *      description="Update DonLeg",
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Bearer token for authentication",
     *           @OA\Schema(
     *             type="string"
     *          ),
     *          required=true,
     *          in="header"
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="id of DonLeg",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/DonLeg")
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
     *                  ref="#/components/schemas/DonLeg"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDonLegAPIRequest $request): JsonResponse
    {
        /** @var DonLeg $donLeg */
        $donLeg = DonLeg::find($id);

        if (empty($donLeg)) {
            return $this->sendError('Don Leg not found');
        }

        $donLeg->fill($request->all());
        $donLeg->save();

        return $this->sendResponse(new DonLegResource($donLeg), 'DonLeg updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/don-legs/{id}",
     *      summary="deleteDonLeg",
     *      tags={"DonLeg"},
     *      description="Delete DonLeg",
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Bearer token for authentication",
     *           @OA\Schema(
     *             type="string"
     *          ),
     *          required=true,
     *          in="header"
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="id of DonLeg",
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
        /** @var DonLeg $donLeg */
        $donLeg = DonLeg::find($id);

        if (empty($donLeg)) {
            return $this->sendError('Don Leg not found');
        }

        $donLeg->delete();

        return $this->sendSuccess('Don Leg deleted successfully');
    }
}
