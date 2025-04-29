<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Workship",
 *      required={"amount"},
 *      @OA\Property(
 *          property="amount",
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
 *          property="user_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *          format="int32"
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
class Workship extends Model
{
    use SoftDeletes, HasFactory;    
    public $table = 'workships';

    public $fillable = [
        'amount',
        'comment',
        'user_id'
    ];

    protected $casts = [
        'amount' => 'integer',
        'comment' => 'string'
    ];

    public static array $rules = [
        'amount' => 'required'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
