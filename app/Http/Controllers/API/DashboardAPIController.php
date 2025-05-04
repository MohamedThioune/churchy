<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Enums\Rolenum;
use App\Http\Resources\UserResource;

class DashboardAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/dashboard/home",
     *      summary="DashboardHome",
     *      tags={"Dashboard"},
     *      description="Get dashboard informations",
     *      @OA\Parameter(
     *          name="startDate",
     *          description="Start date ex: 2025-04-01",
     *           @OA\Schema(
     *             type="date"
     *          ),
     *          in="query"
     *      ),
     *      @OA\Parameter(
     *          name="endDate",
     *          description="End date ex: 2025-04-30",
     *           @OA\Schema(
     *             type="date"
     *          ),
     *          in="query"
     *      ),
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
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
    */
    public function index(Request $request): JsonResponse
    {
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        //Queries
        $expensesQuery = DB::table('expenses')->whereNull('deleted_at');
        $depositsQuery = DB::table('deposits')->whereNull('deleted_at');
        $demandsQuery = DB::table('demands')->whereNull('deleted_at');
        $workshipsQuery = DB::table('workships')->whereNull('deleted_at');
        $tithesQuery = DB::table('tithes')->whereNull('deleted_at');
        $paymentsQuery = DB::table('payments')->whereNull('deleted_at');
        $sacramentsQuery = DB::table('sacraments')->whereNull('deleted_at');
        $don_legsQuery = DB::table('don_legs')->whereNull('deleted_at');
        if ($startDate && $endDate):
            $expensesQuery->whereBetween('dated_at', [$startDate, $endDate]);
            $depositsQuery->whereBetween('dated_at', [$startDate, $endDate]);
            $demandsQuery->whereBetween('dated_at', [$startDate, $endDate]);
            $workshipsQuery->whereBetween('dated_at', [$startDate, $endDate]);
            $tithesQuery->whereBetween('dated_at', [$startDate, $endDate]);
            $paymentsQuery->whereBetween('dated_at', [$startDate, $endDate]);
            $sacramentsQuery->whereBetween('dated_at', [$startDate, $endDate]);
            $don_legsQuery->whereBetween('dated_at', [$startDate, $endDate]);
        endif;
        
        // Fetching data dashboard from the database
        $data = array(
            'Depenses' => [
                'operations' => $expensesQuery->count(),
                'montant' => $expensesQuery->sum('amount'),
            ],
            'Versements' => [
                'operations' => $depositsQuery->count(),
                'montant' => $depositsQuery->sum('amount'),
            ],
            'Messes' => [
                'operations' => $demandsQuery->count(),
                // 'montant' => $demands->sum('amount'),
            ],
            'Cultes' => [
                'operations' => $workshipsQuery->count(),
                'montant' => $workshipsQuery->sum('amount'),
            ],
            'Dimes' => [
                'operations' => $tithesQuery->count(),
                'montant' => $tithesQuery->sum('amount'),
            ],
            'Paiements' => [
                'operations' => $paymentsQuery->count(),
                'montant' => $paymentsQuery->sum('amount'),
            ],
            'Sacrements' => [
                'operations' => $sacramentsQuery->count(),
                'montant' => $sacramentsQuery->sum('amount'),
            ],
            'DonsLegs' => [
                'operations' => $don_legsQuery->count(),
                'montant' => $don_legsQuery->sum('amount'),
            ],
        );
        
        return $this->sendResponse($data, 'Dashboard data retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/users",
     *      summary="getUserList",
     *      tags={"User"},
     *      description="Get all Users",
     *      @OA\Parameter(
     *          name="skip",
     *          description="skip element",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          in="query"
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          description="limit elements",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          in="query"
     *      ),
     *      @OA\Parameter(
     *          name="role",
     *          description="role of the user ('Caisse' or 'User' for christian users)",
     *           @OA\Schema(
     *             type="string"
     *          ),
     *          in="query"
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
     *                  @OA\Items(ref="#/components/schemas/User")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
    */
    public function users(Request $request): JsonResponse
    {
        $query = User::query();

        if ($request->get('skip')) 
            $query->skip($request->get('skip'));
        
        if ($request->get('limit')) 
            $query->limit($request->get('limit'));
        
        $role = $request->get('role');

        match ($role) {
            Rolenum::CASHIER->value    => $query->role(Rolenum::CASHIER->value),
            Rolenum::CHRISTIAN->value  => $query->role(Rolenum::CHRISTIAN->value),
            default => $query->whereDoesntHave('roles', fn ($q) =>
                $q->where('name', Rolenum::ADMIN->value)
            ),
        };
            
        $users = $query->get();

        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully !');
    }
}
