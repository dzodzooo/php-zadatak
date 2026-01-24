<?php
declare(strict_types=1);
namespace App\Service;

use App\Contract\EmailServiceInterface;
use App\Exception\EmailException;

class EmailService implements EmailServiceInterface
{
    public function send(string $email, string $subject, string $message, array $additional_headers)
    {
        if (!$return_value = mail($email, $subject, $message, $additional_headers)) {
            $error = json_encode($return_value);
            throw new EmailException("Couldn't send email {$error}");
        }
    }
    public function sendWelcomeMessage(string $email)
    {
        $subject = "Dobro došli";
        $message = "Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu ...";
        $additional_headers = [
            'from' => 'adm@example.com',
        ];
        "adm@kkk.com";
        $this->send($email, $subject, $message, $additional_headers);
    }
}