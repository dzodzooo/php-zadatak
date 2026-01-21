<?php
declare(strict_types=1);
namespace Service;

use Contract\EmailServiceInterface;
use Exception\EmailException;

class EmailService implements EmailServiceInterface
{
    public function send(string $email, string $subject, string $message, string $additional_headers)
    {
        mail($email, $subject, $message, $additional_headers);
    }
    public function sendWelcomeMessage(string $email)
    {
        $subject = "Dobro došli";
        $message = "Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu ...";
        $additional_headers = "adm@kkk.com";
        $this->send($email, $subject, $message, $additional_headers);
    }
}