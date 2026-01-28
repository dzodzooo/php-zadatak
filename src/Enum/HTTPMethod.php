<?php
declare(strict_types=1);
namespace Zadatak\Enum;
enum HTTPMethod: string
{
    case GET = "GET";
    case POST = "POST";
    case UPDATE = "UPDATE";
    case DELETE = "DELETE";
}