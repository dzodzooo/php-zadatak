<?php
declare(strict_types=1);
namespace Zadatak\Controller;

use Zadatak\Contract\SessionInterface;
use Zadatak\Database\Database;
use Zadatak\Database\UserRepository;
use Zadatak\DataObject\UserData;
use Zadatak\Email\UserMailerFactory;
use Zadatak\Contract\RequestInterface;
use Zadatak\Contract\ResponseInterface;
use Zadatak\Enum\StatusCode;
use Zadatak\Handler\Request\Response;
use Zadatak\Service\AuthService;
use Zadatak\Service\Session;

class AuthController
{
    private static ?AuthController $instance = null;

    private function __construct(
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

    public function register(RequestInterface $request): ResponseInterface
    {
        $requestBody = $request->getBody();

        $userData = new UserData($requestBody['email'], $requestBody['password'], $requestBody['confirmPassword']);

        $userId = $this->auth->register($userData);

        $this->session->regenerateId();

        $this->session->set('userId', $userId);

        return (new Response())->withStatusCode(StatusCode::FOUND)->withHeader('Location', '/');
    }

    public function get(RequestInterface $request): ResponseInterface
    {
        return new Response()
            ->withStatusCode(StatusCode::OK)
            ->withBody("Welcome.");
    }
    public function delete()
    {
    }
}