<?php declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsAiStrategy extends Constraint
{
    public string $message = '"{{ string }}" is not a valid game strategy.';
}
