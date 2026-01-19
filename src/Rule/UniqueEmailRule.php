<?php
declare(strict_types=1);
namespace Rule;

use Database\UserRepository;

class UniqueEmailRule extends Rule
{
    public function __construct()
    {
        parent::__construct();
    }
    public function validate(string $input): bool
    {
        $userRepository = new UserRepository();
        $userRepository->connect(username: 'my_user', password: 'my_password');
        $result = $userRepository->selectUser($input);

        if (is_array($result)) {
            $this->errorMessage = "Email taken.";
            return false;
        }

        return true;
    }
}