<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Enums\Rolenum;

/**
 * @OA\Schema(
 *      schema="User",
 *      required={"first_name","last_name", "email", "gender", "password"},
 *      @OA\Property(
 *          property="first_name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="last_name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="password",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="gender",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="birthday",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *     
 *      @OA\Property(
 *          property="phone",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="address",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
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
class User extends Authenticatable
{
    public $table = 'users';

    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone',
        'avatar',
        'birthday',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static array $login = [
        'email' => 'required|email|string',
        'password' => 'required|string'
    ];

    public static array $register = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string',
        'gender' => 'required|string|in:Homme,Femme',
        'role' => 'required|string|in:' . Rolenum::ADMIN->value .','. Rolenum::CASHIER->value . ','. Rolenum::CHRISTIAN->value,

    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function demands()
    {
        return $this->hasMany(Demand::class);
    }

    public function workships()
    {
        return $this->hasMany(Workship::class);
    }

    public function tithes()
    {
        return $this->hasMany(Tithe::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function sacraments()
    {
        return $this->hasMany(Sacrament::class);
    }

    public function donlegs()
    {
        return $this->hasMany(DonLeg::class);
    }

}
