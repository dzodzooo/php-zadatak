<?php
declare(strict_types=1);
namespace App\DataObject;

use App\Enum\UserAction;

class UserLog
{
    public function __construct(
        public int $userId,
        public UserAction $action
    ) {

    }
}