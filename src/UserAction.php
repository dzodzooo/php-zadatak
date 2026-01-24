<?php
declare(strict_types=1);
namespace App;

enum UserAction: string
{
    case Register = "register";
    case Login = "login";
}