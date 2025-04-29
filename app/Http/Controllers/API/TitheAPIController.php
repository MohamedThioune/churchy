<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTitheAPIRequest;
use App\Http\Requests\API\UpdateTitheAPIRequest;
use App\Models\Tithe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TitheResource;

/**
 * Class TitheController
 */

class TitheAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/tithes",
     *      summary="getTitheList",
     *      tags={"Tithe"},
     *      description="Get all Tithes",
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
     *                  @OA\Items(ref="#/components/schemas/Tithe")
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
        $query = Tithe::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $tithes = $query->get();

        return $this->sendResponse(TitheResource::collection($tithes), 'Tithes retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/tithes",
     *      summary="createTithe",
     *      tags={"Tithe"},
     *      description="Create Tithe",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Tithe")
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
     *                  ref="#/components/schemas/Tithe"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTitheAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Tithe $tithe */
        $tithe = Tithe::create($input);

        return $this->sendResponse(new TitheResource($tithe), 'Tithe saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/tithes/{id}",
     *      summary="getTitheItem",
     *      tags={"Tithe"},
     *      description="Get Tithe",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tithe",
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
     *                  ref="#/components/schemas/Tithe"
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
        /** @var Tithe $tithe */
        $tithe = Tithe::find($id);

        if (empty($tithe)) {
            return $this->sendError('Tithe not found');
        }

        return $this->sendResponse(new TitheResource($tithe), 'Tithe retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/tithes/{id}",
     *      summary="updateTithe",
     *      tags={"Tithe"},
     *      description="Update Tithe",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tithe",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Tithe")
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
     *                  ref="#/components/schemas/Tithe"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTitheAPIRequest $request): JsonResponse
    {
        /** @var Tithe $tithe */
        $tithe = Tithe::find($id);

        if (empty($tithe)) {
            return $this->sendError('Tithe not found');
        }

        $tithe->fill($request->all());
        $tithe->save();

        return $this->sendResponse(new TitheResource($tithe), 'Tithe updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/tithes/{id}",
     *      summary="deleteTithe",
     *      tags={"Tithe"},
     *      description="Delete Tithe",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tithe",
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
        /** @var Tithe $tithe */
        $tithe = Tithe::find($id);

        if (empty($tithe)) {
            return $this->sendError('Tithe not found');
        }

        $tithe->delete();

        return $this->sendSuccess('Tithe deleted successfully');
    }
}
