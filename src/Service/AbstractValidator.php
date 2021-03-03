<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractValidator
{
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    protected function throwFirstErrorAsException(ConstraintViolationListInterface $errorList): void
    {
        if ($errorList->has(0)) {
            throw new ValidationException($errorList->get(0)->getMessage());
        }
    }
}
