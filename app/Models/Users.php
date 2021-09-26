<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class Users extends Authenticable
{
    use HasApiTokens, Notifiable;
    protected $table = 'rc_users';
    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles() {
        return $this->hasOne(UserRoles::class, 'user_id');
    }
}
