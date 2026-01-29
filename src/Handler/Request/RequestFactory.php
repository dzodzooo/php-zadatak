<?php
declare(strict_types=1);
namespace Zadatak\Handler\Request;
use Zadatak\Handler\Request\Request;
class RequestFactory
{
    public static function get(): Request
    {
        $request = new Request();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === "application/json") {
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData);
            $request->withBody((array) $data);
        }

        return $request;
    }
}