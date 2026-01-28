<?php
declare(strict_types=1);
namespace Zadatak\DataObject;

use Zadatak\Enum\UserAction;

class UserLog
{
    public function __construct(
        public int $userId,
        public UserAction $action
    ) {

    }
}