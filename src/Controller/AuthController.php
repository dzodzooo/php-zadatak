<?php
declare(strict_types=1);
namespace Zadatak\Controller;

use Zadatak\Contract\SessionInterface;
use Zadatak\Database\Database;
use Zadatak\Database\UserRepository;
use Zadatak\DataObject\UserData;
use Zadatak\Service\AuthService;
use Zadatak\Service\EmailService;
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
            $session = new Session();
            static::$instance = new AuthController(
                new AuthService(
                    new UserRepository(new Database()),
                    new EmailService(),
                    $session
                ),
                $session,
            );
        }

        return static::$instance;
    }

    public function register()
    {
        $userData = new UserData($_REQUEST['email'], $_REQUEST['password'], $_REQUEST['confirmPassword']);

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