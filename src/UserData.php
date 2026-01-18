<?php
declare(strict_types=1);
class UserData
{
    public function __construct(
        public string $email,
        public string $password,
        public string $confirmPassword
    ) {
    }
}