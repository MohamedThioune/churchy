<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Deposit",
 *      required={"amount","destination","user_id"},
 *      @OA\Property(
 *          property="amount",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *          format="int32"       
 *      ),
 *      @OA\Property(
 *          property="destination",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
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
 *          property="created_at",
 *          description="Date du versement",
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
class Deposit extends Model
{
    use SoftDeletes,HasFactory;    
    public $table = 'deposits';

    public $fillable = [
        'amount',
        'destination',
        'user_id',
        'comment'
    ];

    protected $casts = [
        // 'user_id' => 'integer',
        'destination' => 'string',
        'comment' => 'string'
    ];

    public static array $rules = [
        'amount' => 'required|integer',
        'destination' => 'required|string|max:250',
        'user_id' => 'integer|exists:users,id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }   

    
}
