<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="File",
 *      required={"type","path", "meaning", "user_id"},
 *      @OA\Property(
 *          property="type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="path",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="meaning",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="description",
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

class File extends Model
{
    use SoftDeletes, HasFactory;    
    public $table = 'files';

    public $fillable = [
        'id', // Unique identifier for the file
        'type', // Extension of the file
        'path', // Directory path of the file
        'meaning', // Meaning of the file (License, CIN, Certificate, etc.)
        'description', // Description of the file
        'user_id' //Attached user
    ];

    protected $casts = [
        'id' => 'string',
        'type' => 'string',
        'path' => 'string',
        'meaning' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'type' => 'required',
        'path' => 'required',
        'meaning' => 'required',
        'user_id' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
