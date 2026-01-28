<?php
declare(strict_types=1);
namespace Zadatak\DataObject;
class UserData
{
    public function __construct(
        public string $email,
        public string $password,
        public string $confirmPassword
    ) {
    }
}