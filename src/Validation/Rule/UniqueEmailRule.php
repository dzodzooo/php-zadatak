<?php
declare(strict_types=1);
namespace Zadatak\Validation\Rule;

use Zadatak\Database\Database;
use Zadatak\Database\UserRepository;

class UniqueEmailRule extends Rule
{
    public function validate(array $data, string $key): bool
    {
        $userRepository = new UserRepository(new Database());
        $userRepository->connect();
        $result = $userRepository->selectUser($data[$key]);

        if (is_array($result)) {
            $this->errorMessage = "Email taken.";
            return false;
        }

        return true;
    }
}