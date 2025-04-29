<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSacramentAPIRequest;
use App\Http\Requests\API\UpdateSacramentAPIRequest;
use App\Models\Sacrament;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SacramentResource;

/**
 * Class SacramentController
 */

class SacramentAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/sacraments",
     *      summary="getSacramentList",
     *      tags={"Sacrament"},
     *      description="Get all Sacraments",
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
     *                  @OA\Items(ref="#/components/schemas/Sacrament")
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
        $query = Sacrament::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $sacraments = $query->get();

        return $this->sendResponse(SacramentResource::collection($sacraments), 'Sacraments retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/sacraments",
     *      summary="createSacrament",
     *      tags={"Sacrament"},
     *      description="Create Sacrament",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Sacrament")
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
     *                  ref="#/components/schemas/Sacrament"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSacramentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Sacrament $sacrament */
        $sacrament = Sacrament::create($input);

        return $this->sendResponse(new SacramentResource($sacrament), 'Sacrament saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/sacraments/{id}",
     *      summary="getSacramentItem",
     *      tags={"Sacrament"},
     *      description="Get Sacrament",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Sacrament",
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
     *                  ref="#/components/schemas/Sacrament"
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
        /** @var Sacrament $sacrament */
        $sacrament = Sacrament::find($id);

        if (empty($sacrament)) {
            return $this->sendError('Sacrament not found');
        }

        return $this->sendResponse(new SacramentResource($sacrament), 'Sacrament retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/sacraments/{id}",
     *      summary="updateSacrament",
     *      tags={"Sacrament"},
     *      description="Update Sacrament",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Sacrament",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Sacrament")
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
     *                  ref="#/components/schemas/Sacrament"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSacramentAPIRequest $request): JsonResponse
    {
        /** @var Sacrament $sacrament */
        $sacrament = Sacrament::find($id);

        if (empty($sacrament)) {
            return $this->sendError('Sacrament not found');
        }

        $sacrament->fill($request->all());
        $sacrament->save();

        return $this->sendResponse(new SacramentResource($sacrament), 'Sacrament updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/sacraments/{id}",
     *      summary="deleteSacrament",
     *      tags={"Sacrament"},
     *      description="Delete Sacrament",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Sacrament",
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
        /** @var Sacrament $sacrament */
        $sacrament = Sacrament::find($id);

        if (empty($sacrament)) {
            return $this->sendError('Sacrament not found');
        }

        $sacrament->delete();

        return $this->sendSuccess('Sacrament deleted successfully');
    }
}
