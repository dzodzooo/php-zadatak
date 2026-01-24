<?php
declare(strict_types=1);
namespace App\Service;

use App\DataObject\ScoreMock;
use DateTime;

class MinFraudMock
{
    public function withDevice(
        string $ipaddress,
        DateTime $sessionAge,
        string $sessionId,
        string $userAgent,
        string $acceptLanguage
    ) {

    }

    public function score()
    {
        return new ScoreMock(rand(-1, 1));
    }
}