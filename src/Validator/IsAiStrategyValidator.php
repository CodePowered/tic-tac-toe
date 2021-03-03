<?php declare(strict_types=1);

namespace App\Validator;

use App\Exception\UnsupportedException;
use App\Service\AiStrategyCollection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IsAiStrategyValidator extends ConstraintValidator
{
    private AiStrategyCollection $collection;

    public function __construct(AiStrategyCollection $collection)
    {
        $this->collection = $collection;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsAiStrategy) {
            throw new UnexpectedTypeException($constraint, IsAiStrategy::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        try {
            $this->collection->getStrategy($value);
        } catch (UnsupportedException $exception) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
