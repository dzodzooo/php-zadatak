<?php
declare(strict_types=1);
namespace Contract;

interface EmailServiceInterface
{
    public function send(string $email, string $subject, string $message, string $additional_headers);
    public function sendWelcomeMessage(string $email);
}