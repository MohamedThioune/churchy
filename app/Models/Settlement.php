<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'settlements';

    public $fillable = [
        'user_id',
        'quest_id'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'quest_id' => 'integer',
    ];

    public static array $rules = [
        'user_id' => 'required|integer',
        'quest_id' => 'required|integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }
}
