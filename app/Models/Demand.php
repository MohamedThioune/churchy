<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Demand",
 *      required={"type","amount","intention","user_id","dated_at"},
 *      @OA\Property(
 *          property="type",
 *          description="Type d'intention",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="intention",
 *          description="Intention de la messe",
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
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="comment",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="dated_at",
 *          description="Date de la demande",
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
class Demand extends Model
{
    use SoftDeletes, HasFactory;    
    public $table = 'demands';

    public $fillable = [
        'type',
        'intention',
        'amount',
        'user_id',
        'comment',
        'dated_at'
    ];

    protected $casts = [
        'type' => 'string',
        'intention' => 'string',
        'comment' => 'string',
        'dated_at' => 'datetime',
    ];

    public static array $rules = [
        'type' => 'required|string|max:255',
        'amount' => 'required|integer',
        'intention' => 'required|string|max:255',
        'user_id' => 'integer|exists:users,id',
        'dated_at' => 'required',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
