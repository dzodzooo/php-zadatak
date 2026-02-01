<?php
declare(strict_types=1);
namespace Zadatak\Validation\Rule;

use Zadatak\Contract\RequestInterface;
use Zadatak\Exception\ValidationException;
use Zadatak\Service\MinFraudMock;
use Zadatak\Service\Session;

class MinfraudRule extends Rule
{
    private Session $session;
    private MinFraudMock $minFraud;
    private RequestInterface $request;
    public function __construct(array $args)
    {
        parent::__construct();

        if (count(array_diff_key(array_flip(['session', 'minFraud', 'request']), $args)) !== 0)
            throw new ValidationException('Invalid arguments.');

        $this->session = $args['session'];
        $this->minFraud = $args['minFraud'];
        $this->request = $args['request'];
    }
    public function validate(array $data, string $key): bool
    {
        $this->minFraud->withDevice(
            $this->request->getServerParams()['REMOTE_ADDR'],
            $this->session->get('start_time'),
            $this->session->getId(),
            $this->request->getServerParams()['HTTP_USER_AGENT'],
            'en-US,en;q=0.8'
        );

        if ($this->minFraud->score()->riskScore < 0)
            return true;

        $this->errorMessage = "MinFraud validation failed";
        return false;
    }
}
