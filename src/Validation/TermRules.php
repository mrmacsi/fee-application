<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Validation;

use Lendable\Interview\Interpolation\Exception\TermValidationException;

class TermRules implements Rules
{
    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     * @throws TermValidationException
     */
    public function rules(): bool
    {
        if (!in_array($this->value, [12, 24])) {
            throw new TermValidationException('Term must be 12 or 24 months');
        }
        return true;
    }
}