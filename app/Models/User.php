<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Auth;

class User extends Authenticatable implements JWTSubject
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'mobile',
        'password',
        'usertype',
        'email_verified_at',
        'profile_photo',
        'two_factor_code',
        'last_login_date',
        'registered_by'
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
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    static function UpdateLoginDate($id)
    {
        self::where('id', $id)->update(['last_login_date' => date("Y-m-d H:m:s")]);
    }
    static function UserType()
    {
        return Auth::user()->usertype;
        // return UserRole::select('role_master.RoleName')->join('role_master','role_master.Id','user_role.RoleId')->where('user_role.UserId', Auth::user()->Id)->first()->RoleName;
    }
}
