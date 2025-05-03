<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Expense",
 *      required={"reason","type","amount","authorizer"},
 *      @OA\Property(
 *          property="reason",
 *          description="Motif",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="Type de dépense|in:Salaires et honoraires,Aide aux paroissiens,Événements paroissiaux,Frais administratifs,Autres",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="amount",
 *          description="Montant",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="authorizer",
 *          description="Ordonnateur|in:Curé,Trésorier,Vicaire,Autres",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="comment",
 *          description="Commentaire",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="dated_at",
 *          description="Date de la dépense",
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
class Expense extends Model
{
    use SoftDeletes, HasFactory;    
    public $table = 'expenses';

    public $fillable = [
        'reason',
        'type',
        'amount',
        'authorizer',
        'comment',
        'dated_at'
    ];

    protected $casts = [
        'reason' => 'string',
        'type' => 'string',
        'amount' => 'integer',
        'authorizer' => 'string',
        'comment' => 'string',
        'dated_at' => 'datetime',
    ];

    public static array $rules = [
        'reason' => 'required|string|max:250',
        'type' => 'required|string|max:250|in:Salaires et honoraires,Aide aux paroissiens,Événements paroissiaux,Frais administratifs,Autres',
        'amount' => 'required|numeric',
        'authorizer' => 'required|string|max:250|in:Curé,Trésorier,Vicaire,Autres',
    ];
    
}
