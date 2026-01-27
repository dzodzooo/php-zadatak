<?php
declare(strict_types=1);
namespace App\Enum;
enum HTTPMethod: string
{
    case GET = "GET";
    case POST = "POST";
    case UPDATE = "UPDATE";
    case DELETE = "DELETE";
}