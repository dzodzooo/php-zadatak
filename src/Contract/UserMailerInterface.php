<?php
declare(strict_types=1);
namespace Zadatak\Contract;

interface UserMailerInterface
{
    public function sendWelcomeMessage(string $email);
}