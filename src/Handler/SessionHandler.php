<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Contract\SessionInterface;

class SessionHandler extends Handler implements HandlerInterface
{
    public function __construct(private readonly SessionInterface $session)
    {
    }
    public function handle($request)
    {
        $this->session->start();

        $response = $this->handler->handle($request);

        $this->session->close();

        return $response;
    }
}
