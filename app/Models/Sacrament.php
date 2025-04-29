<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Sacrament",
 *      required={"reason","amount","sacramented_at"},
 *      @OA\Property(
 *          property="reason",
 *          description="Motif du sacrement|in:Confirmation,Baptême,Première communion,Mariage,Ordre,Onction des malades'",
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
 *          property="sacramented_at",
 *          description="Date du sacrement",
 *          readOnly=false,
 *          nullable=false,
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
 */class Sacrament extends Model
{
    use SoftDeletes, HasFactory;    
    public $table = 'sacraments';

    public $fillable = [
        'reason',
        'amount',
        'user_id',
        'sacramented_at'
    ];

    protected $casts = [
        'reason' => 'string',
        'amount' => 'integer',
        'sacramented_at' => 'datetime',
    ];

    public static array $rules = [
        'reason' => 'required|string|max:255|in:Confirmation,Baptême,Première communion,Mariage,Ordre,Onction des malades',
        'amount' => 'required|integer',
        'user_id' => 'integer|exists:users,id',
        'sacramented_at' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
