<?php
declare(strict_types=1);
namespace Zadatak\Validation;

use Zadatak\DataObject\UserData;
use Zadatak\Service\MinFraudMock;
use Zadatak\Service\Session;

class UserDataValidatorFactory
{
    public static function create(Session $session)
    {
        $validator = new Validator();

        $validator->addRule('email', 'required');
        $validator->addRule('email', 'email');
        $validator->addRule('email', 'unique email');
        $validator->addRule('email', 'minfraud', ['session' => $session, 'minFraud' => new MinFraudMock()]);

        $validator->addRule('password', 'required');
        $validator->addRule('password', 'min', ['min' => 6]);

        $validator->addRule('confirmPassword', 'required');
        $validator->addRule('confirmPassword', 'min', ['min' => 6]);
        $validator->addRule('confirmPassword', 'same', ['same' => 'password']);
        return $validator;
    }

}