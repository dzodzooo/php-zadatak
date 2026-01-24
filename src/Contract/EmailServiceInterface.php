<?php
declare(strict_types=1);
namespace App\Contract;

interface EmailServiceInterface
{
    public function send(string $email, string $subject, string $message, array $additional_headers);
    public function sendWelcomeMessage(string $email);
}