<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DB;

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
}
