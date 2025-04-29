<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDepositAPIRequest;
use App\Http\Requests\API\UpdateDepositAPIRequest;
use App\Models\Deposit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DepositResource;

/**
 * Class DepositController
 */

class DepositAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/deposits",
     *      summary="getDepositList",
     *      tags={"Deposit"},
     *      description="Get all Deposits",
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
     *                  @OA\Items(ref="#/components/schemas/Deposit")
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
        $query = Deposit::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $deposits = $query->get();

        return $this->sendResponse(DepositResource::collection($deposits), 'Deposits retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/deposits",
     *      summary="createDeposit",
     *      tags={"Deposit"},
     *      description="Create Deposit",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Deposit")
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
     *                  ref="#/components/schemas/Deposit"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDepositAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Deposit $deposit */
        $deposit = Deposit::create($input);

        return $this->sendResponse(new DepositResource($deposit), 'Deposit saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/deposits/{id}",
     *      summary="getDepositItem",
     *      tags={"Deposit"},
     *      description="Get Deposit",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Deposit",
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
     *                  ref="#/components/schemas/Deposit"
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
        /** @var Deposit $deposit */
        $deposit = Deposit::find($id);

        if (empty($deposit)) {
            return $this->sendError('Deposit not found');
        }

        return $this->sendResponse(new DepositResource($deposit), 'Deposit retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/deposits/{id}",
     *      summary="updateDeposit",
     *      tags={"Deposit"},
     *      description="Update Deposit",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Deposit",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Deposit")
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
     *                  ref="#/components/schemas/Deposit"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDepositAPIRequest $request): JsonResponse
    {
        /** @var Deposit $deposit */
        $deposit = Deposit::find($id);

        if (empty($deposit)) {
            return $this->sendError('Deposit not found');
        }

        $deposit->fill($request->all());
        $deposit->save();

        return $this->sendResponse(new DepositResource($deposit), 'Deposit updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/deposits/{id}",
     *      summary="deleteDeposit",
     *      tags={"Deposit"},
     *      description="Delete Deposit",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Deposit",
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
        /** @var Deposit $deposit */
        $deposit = Deposit::find($id);

        if (empty($deposit)) {
            return $this->sendError('Deposit not found');
        }

        $deposit->delete();

        return $this->sendSuccess('Deposit deleted successfully');
    }
}
