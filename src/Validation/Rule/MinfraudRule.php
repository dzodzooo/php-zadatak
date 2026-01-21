<?php
declare(strict_types=1);
namespace Validation\Rule;

use Exception\ValidationException;
use Service\MinFraudMock;
use Service\Session;

class MinfraudRule extends Rule
{
    private Session $session;
    private MinFraudMock $minFraud;
    public function __construct(array $args)
    {
        parent::__construct();
        if (!isset($args['session']))
            throw new ValidationException('Invalid arguments.');
        $this->session = $args['session'];
        $this->minFraud = new MinFraudMock();
    }
    public function validate(string $input): bool
    {
        $client_ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        $this->minFraud->withDevice(
            $client_ip,
            $this->session->get('start_time'),
            $this->session->getId(),
            $userAgent,
            'en-US,en;q=0.8'
        );

        if ($this->minFraud->score()->riskScore < 0)
            return true;

        $this->errorMessage = "MinFraud validation failed";
        return false;
    }
}
