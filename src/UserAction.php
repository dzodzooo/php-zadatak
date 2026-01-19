<?php
declare(strict_types=1);

enum UserAction: string
{
    case Register = "register";
    case Login = "login";
}