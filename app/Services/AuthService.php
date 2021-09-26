<?php

namespace App\Services;

use App\Models\UserRoles;
use App\Models\Users;

class AuthService {

    public static function make() {
        return new static;
    }

    public function registerService($userData) {
        $user = Users::where(['mobile' => $userData['mobile'], 'email' => $userData['email']])->first();
        if(!empty($user)) {
            return false;
        }
        $roleId = $userData['role_id'];
        unset($userData['role_id']);
        $createUser = Users::create($userData);
        $userRole = new UserRoles;
        $userRole->user_id = $createUser->id;
        $userRole->role_id = $roleId;
        $userRole->save();
        return true;
    }

}



