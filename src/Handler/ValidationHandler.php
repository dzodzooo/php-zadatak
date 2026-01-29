<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Contract\SessionInterface;
use Zadatak\Handler\Request\Request;
use Zadatak\Exception\ValidationException;
use Zadatak\Validation\Validator;

class ValidationHandler extends Handler implements HandlerInterface
{
    public function __construct(
        private readonly Validator $validator
    ) {
    }
    public function handle(Request $request)
    {
        $this->validator->validateOn($request->getBody());

        if (!$this->validator->validate()) {
            $errors = $this->validator->getErrorMessages();
            throw new ValidationException(array_pop($errors)[0]);
        }

        return $this->handler->handle($request);
    }
}
