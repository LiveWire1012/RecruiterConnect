<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConnection extends Model
{
    use HasFactory;

    protected $table = 'rc_connections';

    protected $guarded = [];

    const STATUS_ACTIVE = 1;

    public function connectionUser() {
        return $this->hasOne(Users::class, 'id', 'connection_id');
    }

    public function user() {
        return $this->hasOne(Users::class, 'id', 'user_id');
    }

    public function mutualConnection() {
        return $this->hasOne(Users::class, 'id', 'connection_id');
    }

}
