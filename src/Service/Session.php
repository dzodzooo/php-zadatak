<?php
declare(strict_types=1);
namespace Zadatak\Service;

use Zadatak\Contract\SessionInterface;
use DateTime;

class Session implements SessionInterface
{
    public function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['start_time'] = new DateTime();
    }

    public function regenerateId()
    {
        session_regenerate_id();
    }
    public function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }
    public function get(string $key)
    {
        return $_SESSION[$key];
    }

    public function getId()
    {
        return session_id();
    }

    public function close()
    {
        session_write_close();
    }
}