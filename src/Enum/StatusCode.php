<?php
declare(strict_types=1);
namespace Zadatak\Enum;

enum StatusCode: int
{
    case BAD_REQUEST = 400;
    case FOUND = 302;
    case OK = 200;
}