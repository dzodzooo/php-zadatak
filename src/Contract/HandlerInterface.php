<?php
declare(strict_types=1);
namespace Zadatak\Contract;

use Zadatak\Handler\Request\Request;

interface HandlerInterface
{
    public function setHandler(HandlerInterface $handler);

    public function handle(Request $request);
}