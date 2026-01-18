<?php
declare(strict_types=1);
namespace Validation;

use UserData;

class UserDataValidatorFactory
{
    public static function create(UserData $userData)
    {
        $validator = new Validator();
        $validator->validateOn((array) $userData);

        $validator->addRule('email', 'required');
        //$validator->addRule('email', 'email');

        $validator->addRule('password', 'required');
        $validator->addRule('password', 'min', ['min' => 6]);

        $validator->addRule('confirmPassword', 'required');
        $validator->addRule('confirmPassword', 'min', ['min' => 6]);
        $validator->addRule('confirmPassword', 'same', ['same' => 'password']);
        return $validator;
    }

}