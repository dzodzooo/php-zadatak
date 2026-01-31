<?php
declare(strict_types=1);
namespace Zadatak\Email;

use Zadatak\Contract\EmailServiceInterface;
use Zadatak\Contract\UserMailerInterface;
use Zadatak\DataObject\Email;

class UserMailer implements UserMailerInterface
{
    private Email $email;
    public function __construct(
        private readonly EmailServiceInterface $emailService,
        private readonly EmailConfig $emailConfig,
    ) {
    }

    public function setEmail(Email $email)
    {
        $this->email = $email;
        return $this;
    }

    public function sendWelcomeMessage(string $email)
    {
        $this->emailService->send(
            $email,
            $this->email->subject,
            $this->email->message,
            $this->emailConfig->additionalHeaders
        );
    }
}