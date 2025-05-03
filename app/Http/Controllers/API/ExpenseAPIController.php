<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateExpenseAPIRequest;
use App\Http\Requests\API\UpdateExpenseAPIRequest;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ExpenseResource;

/**
 * Class ExpenseController
 */

class ExpenseAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/expenses",
     *      summary="getExpenseList",
     *      tags={"Expense"},
     *      description="Get all Expenses",
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
     *                  @OA\Items(ref="#/components/schemas/Expense")
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
        $query = Expense::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $expenses = $query->get();

        return $this->sendResponse(ExpenseResource::collection($expenses), 'Expenses retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/expenses",
     *      summary="createExpense",
     *      tags={"Expense"},
     *      description="Create Expense",
     *      security={{"passport":{}}},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Expense")
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
     *                  ref="#/components/schemas/Expense"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateExpenseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Expense $expense */
        $expense = Expense::create($input);

        return $this->sendResponse(new ExpenseResource($expense), 'Expense saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/expenses/{id}",
     *      summary="getExpenseItem",
     *      tags={"Expense"},
     *      description="Get Expense",
     *      security={{"passport":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Expense",
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
     *                  ref="#/components/schemas/Expense"
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
        /** @var Expense $expense */
        $expense = Expense::find($id);

        if (empty($expense)) {
            return $this->sendError('Expense not found');
        }

        return $this->sendResponse(new ExpenseResource($expense), 'Expense retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/expenses/{id}",
     *      summary="updateExpense",
     *      tags={"Expense"},
     *      description="Update Expense",
     *      security={{"passport":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Expense",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Expense")
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
     *                  ref="#/components/schemas/Expense"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateExpenseAPIRequest $request): JsonResponse
    {
        /** @var Expense $expense */
        $expense = Expense::find($id);

        if (empty($expense)) {
            return $this->sendError('Expense not found');
        }

        $expense->fill($request->all());
        $expense->save();

        return $this->sendResponse(new ExpenseResource($expense), 'Expense updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/expenses/{id}",
     *      summary="deleteExpense",
     *      tags={"Expense"},
     *      description="Delete Expense",
     *      security={{"passport":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Expense",
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
        /** @var Expense $expense */
        $expense = Expense::find($id);

        if (empty($expense)) {
            return $this->sendError('Expense not found');
        }

        $expense->delete();

        return $this->sendSuccess('Expense deleted successfully');
    }
}
