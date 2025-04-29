<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Demand",
 *      required={"intention","user_id", "messed_at"},
 *      @OA\Property(
 *          property="intention",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
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
 *          property="messed_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="Date de la demande",
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
        'intention',
        'user_id',
        'comment',
        'messed_at'
    ];

    protected $casts = [
        'intention' => 'string',
        'comment' => 'string',
        'messed_at' => 'datetime',
    ];

    public static array $rules = [
        'intention' => 'required|string|max:255',
        'user_id' => 'integer|exists:users,id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
