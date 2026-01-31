<?php
declare(strict_types=1);
namespace Zadatak\Email;

use Zadatak\Contract\EmailServiceInterface;
use Zadatak\Exception\EmailException;

class EmailService implements EmailServiceInterface
{
    public function send(string $email, string $subject, string $message, array $additional_headers)
    {
        if (!mail($email, $subject, $message, $additional_headers)) {
            throw new EmailException("Couldn't send email.");
        }
    }

}