<?php
declare(strict_types=1);
namespace Zadatak\Contract;

interface HandlerInterface
{
    public function setHandler(HandlerInterface $handler);

    public function handle($request);
}