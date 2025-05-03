<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Quest",
 *      required={"amount","type","location","ceremony","users","quested_at"},
 *      @OA\Property(
 *          property="amount",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="location",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="ceremony",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="users",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="array",
 *          @OA\Items(type="integer", format="int32")
 *      ),
 *      @OA\Property(
 *          property="quested_at",
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
class Quest extends Model
{
    use SoftDeletes, HasFactory;    
    public $table = 'quests';

    public $fillable = [
        'amount',
        'type',
        'location',
        'ceremony',
        'quested_at'
    ];

    protected $casts = [
        'type' => 'string',
        'amount' => 'integer',
        'location' => 'string',
        'ceremony' => 'string',
        'quested_at' => 'datetime',
    ];

    public static array $rules = [
        'user_ids' => 'array',
        'amount' => 'required',
        'type' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'ceremony' => 'required|string|max:255',
        'quested_at' => 'required',
    ];

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function users()
    {
        return $this->hasManyThrough(
            User::class,         // Final model
            Settlement::class,   // Intermediate model
            'quest_id',          // Foreign key on settlements table...
            'id',                // Foreign key on users table...
            'id',                // Local key on quests table...
            'user_id'            // Local key on settlements table...
        );
    }
    
}
