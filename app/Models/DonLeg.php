<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="DonLeg",
 *      required={"type","amount","user_id"},
 *      @OA\Property(
 *          property="type",
 *          description="Type de don|in:Don,Leg,Nature,Espèce",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="amout",
 *          description="Montant",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="dated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
*/
class DonLeg extends Model
{
    use SoftDeletes,HasFactory;    
    public $table = 'don_legs';

    public $fillable = [
        'type',
        'amount',
        'user_id',
        'dated_at'
    ];

    protected $casts = [
        'type' => 'string',
        'amount' => 'integer',
        'dated_at' => 'datetime',
    ];

    public static array $rules = [
        'type' => 'required|in:Don,Leg,Nature,Espèce',
        'amount' => 'required|integer',
        'user_id' => 'required|integer|exists:users,id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
