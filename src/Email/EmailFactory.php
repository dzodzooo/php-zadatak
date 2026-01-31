<?php
declare(strict_types=1);
namespace Zadatak\Email;

use Zadatak\DataObject\Email;

class EmailFactory
{
    public static function createWelcomeEmail(): Email
    {
        return new Email()
            ->setSubject("Dobro došli")
            ->setMessage("Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu ...");
    }
}