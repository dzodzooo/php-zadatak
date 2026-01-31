<?php
declare(strict_types=1);
namespace Zadatak\Email;

use Zadatak\Contract\UserMailerInterface;

class UserMailerFactory
{
    public static function create(): UserMailerInterface
    {
        $userMailer = new UserMailer(
            new EmailService(),
            new EmailConfig()->setHeader('From', 'noreply@example.com')
        );

        $userMailer->setEmail(EmailFactory::createWelcomeEmail());

        return $userMailer;
    }
}