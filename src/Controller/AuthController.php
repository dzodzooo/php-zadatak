<?php
declare(strict_types=1);
namespace Zadatak\Controller;

use Zadatak\Contract\SessionInterface;
use Zadatak\Database\Database;
use Zadatak\Database\UserRepository;
use Zadatak\Handler\Request\Request;
use Zadatak\DataObject\UserData;
use Zadatak\Email\UserMailerFactory;
use Zadatak\Service\AuthService;
use Zadatak\Service\Session;

class AuthController
{
    private static ?AuthController $instance = null;

    public function __construct(
        private readonly AuthService $auth,
        private readonly SessionInterface $session
    ) {
    }
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new AuthController(
                new AuthService(
                    new UserRepository(new Database()),
                    UserMailerFactory::create()
                ),
                new Session(),
            );
        }

        return static::$instance;
    }

    public function register(Request $request)
    {
        $requestBody = $request->getBody();

        $userData = new UserData($requestBody['email'], $requestBody['password'], $requestBody['confirmPassword']);

        $userId = $this->auth->register($userData);

        $this->session->regenerateId();

        $this->session->set('userId', $userId);
    }

    public function get()
    {
        echo "Welcome";
    }
    public function delete()
    {
    }
}