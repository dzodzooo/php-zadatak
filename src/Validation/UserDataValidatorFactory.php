<?php
declare(strict_types=1);
namespace App\Validation;

use App\DataObject\UserData;
use App\Service\Session;

class UserDataValidatorFactory
{
    public static function create(UserData $userData, Session $session)
    {
        $validator = new Validator();
        $validator->validateOn((array) $userData);

        $validator->addRule('email', 'required');
        $validator->addRule('email', 'email');
        $validator->addRule('email', 'unique email');
        $validator->addRule('email', 'minfraud', ['session' => $session]);

        $validator->addRule('password', 'required');
        $validator->addRule('password', 'min', ['min' => 6]);

        $validator->addRule('confirmPassword', 'required');
        $validator->addRule('confirmPassword', 'min', ['min' => 6]);
        $validator->addRule('confirmPassword', 'same', ['same' => 'password']);
        return $validator;
    }

}