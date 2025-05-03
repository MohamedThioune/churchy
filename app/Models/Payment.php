<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Payment",
 *      required={"type","target","amount"},
 *      @OA\Property(
 *          property="type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="target",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="amount",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
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
 *          description="Date d'enregistrement",
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
 */class Payment extends Model
{
    use SoftDeletes,HasFactory;    
    public $table = 'payments';

    public $fillable = [
        'type',
        'target',
        'amount',
        'user_id',
        'dated_at'
    ];

    protected $casts = [
        'type' => 'string',
        'target' => 'string',
        'amount' => 'integer',
        'dated_at' => 'datetime',
    ];

    public static array $rules = [
        'type' => 'required',
        'target' => 'required|string|max:255',
        'amount' => 'required|integer',
        'user_id' => 'integer|exists:users,id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    
}
