<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Contract\SessionInterface;
use Zadatak\DataObject\Request;
use Zadatak\DataObject\Response;

class SessionHandler extends Handler implements HandlerInterface
{
    public function __construct(private readonly SessionInterface $session)
    {
    }
    public function handle(Request $request)
    {
        $this->session->start();

        $this->handler->handle($request);

        $this->session->close();
    }
}
