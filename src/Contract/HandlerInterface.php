<?php
declare(strict_types=1);
namespace Zadatak\Contract;

use RecursiveArrayIterator;
use Zadatak\DataObject\Request;
use Zadatak\DataObject\Response;

interface HandlerInterface
{
    public function setHandler(HandlerInterface $handler);

    public function handle(Request $request);
}