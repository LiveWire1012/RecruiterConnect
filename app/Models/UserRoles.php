<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;

    protected $table = 'rc_user_roles';
    protected $guarded = [];

    protected $fillable = ['role_id'];

    public function roleDetails() {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }

}
