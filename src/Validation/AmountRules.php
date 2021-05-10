<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Validation;

use Lendable\Interview\Interpolation\Exception\AmountValidationException;

class AmountRules implements Rules
{

    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     * @throws AmountValidationException
     */
    public function rules(): bool
    {
        if ($this->value < 1000 || $this->value > 20000) {
            throw new AmountValidationException('Amount must be between 1,000 and 20,000');
        }
        if ($this->value % 5 !== 0) {
            throw new AmountValidationException('Amount is not multiple by 5');
        }
        return true;
    }
}