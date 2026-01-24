<?php
declare(strict_types=1);
namespace App\Contract;
interface SessionInterface
{
    public function start();
    public function regenerateId();
    public function set(string $key, mixed $value);
    public function get(string $key);
    public function getId();
}