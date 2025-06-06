<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Tithe",
 *      required={"amount", "user_id"},
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
 *          description="Date du dimes",
 *          readOnly=false,
 *          nullable=false,
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
class Tithe extends Model
{
    use SoftDeletes, HasFactory;    
    public $table = 'tithes';

    public $fillable = [
        'amount',
        'user_id',
        'dated_at'
    ];

    protected $casts = [
        'amount' => 'integer',
        'dated_at' => 'datetime',
    ];

    public static array $rules = [
        'amount' => 'required|integer',
        'user_id' => 'integer|exists:users,id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    
}
