<?php
declare(strict_types=1);
namespace Zadatak\Enum;

enum UserAction: string
{
    case Register = "register";
    case Login = "login";
}