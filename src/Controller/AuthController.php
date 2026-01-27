<?php
declare(strict_types=1);
namespace App\Controller;

use App\Contract\SessionInterface;
use App\Database\Database;
use App\Database\UserRepository;
use App\DataObject\UserData;
use App\Service\AuthService;
use App\Service\EmailService;
use App\Service\Session;

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

    public function post()
    {
        $userData = new UserData($_REQUEST['email'], $_REQUEST['password'], $_REQUEST['confirmPassword']);

        $this->session->start();

        $userId = $this->auth->register($userData);

        $this->session->regenerateId();

        $this->session->set('userId', $userId);
    }

    public function get()
    {
        echo "Welcome";
    }
}