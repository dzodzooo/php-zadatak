<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Contract\SessionInterface;
use Zadatak\DataObject\Request;
use Zadatak\DataObject\Response;
use Zadatak\Exception\ValidationException;
use Zadatak\Validation\Validator;

class ValidationHandler extends Handler implements HandlerInterface
{
    public function __construct(
        private readonly Validator $validator,
        private readonly SessionInterface $session
    ) {
    }
    public function handle(Request $request)
    {
        if (!$this->session->get('userId'))
            return $this->handler->handle($request);

        $this->validator->validateOn($request->get('userData'));

        if (!$this->validator->validate()) {
            $errors = $this->validator->getErrorMessages();
            throw new ValidationException(array_pop($errors)[0]);
        }

        return $this->handler->handle($request);
    }
}
