<?php

namespace App\Repositories;

class BaseRepo {

    public static function make() {
        return new static;
    }

}
