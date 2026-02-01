<?php

declare(strict_types=1);
namespace Zadatak\Validation;

use Zadatak\Contract\SessionInterface;
use Zadatak\Handler\Request\Request;
use Zadatak\Service\MinFraudMock;

class UserDataValidatorFactory
{
    public static function create(SessionInterface $session)
    {
        $validator = new Validator();

        $validator->addRule('email', 'required');
        $validator->addRule('email', 'email');
        $validator->addRule('email', 'unique email');
        $validator->addRule('email', 'minfraud', [
            'session' => $session,
            'minFraud' => new MinFraudMock(),
            'request' => new Request(),
        ]);

        $validator->addRule('password', 'required');
        $validator->addRule('password', 'min', ['min' => 6]);

        $validator->addRule('confirmPassword', 'required');
        $validator->addRule('confirmPassword', 'min', ['min' => 6]);
        $validator->addRule('confirmPassword', 'same', ['same' => 'password']);

        return $validator;
    }

}