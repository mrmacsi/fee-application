<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Validation;

use Exception;
use Lendable\Interview\Interpolation\Model\LoanApplication;

class Validator
{
    /**
     * @param LoanApplication $loanApplication
     * @return bool
     * @throws Exception
     */
    public function validate(LoanApplication $loanApplication): bool
    {
        $this
            ->rules(new AmountRules($loanApplication->amount()))
            ->rules(new TermRules($loanApplication->term()));
        return true;
    }

    /**
     * @param Rules $rules
     * @return Validator
     * @throws Exception
     */
    public function rules(Rules $rules): Validator
    {
        if ($rules instanceof AmountRules) {
            $rules->rules();
            return $this;
        } elseif ($rules instanceof TermRules) {
            $rules->rules();
            return $this;
        } else {
            throw new Exception('Rule is not found');
        }
    }
}