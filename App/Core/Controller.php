<?php

namespace App\Core;

use App\Core\Helpers\Validator;

abstract class Controller
{
    public $validateErrors = [];

    public function validate(array $validator): bool
    {
        foreach ($validator as $value => $rules) {
            if (!Validator::is($value, $rules, $this->validateErrors)) {
                return false;
            }
        }

        return true;
    }
}
