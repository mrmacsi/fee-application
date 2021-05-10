<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation;

use Exception;
use Lendable\Interview\Interpolation\Model\Calculator;
use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Validation\Validator;

class FeeApplication implements FeeCalculator
{
    /**
     * @var Validator
     */
    private $validator;
    /**
     * @var Calculator
     */
    private $calculator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->calculator = new Calculator();
    }

    /**
     * @param LoanApplication $application
     * @return float
     * @throws Exception
     */
    public function calculate(LoanApplication $application): float
    {
        $amount = $application->amount();
        $term = $application->term();
        $this->validator->validate($application);
        $totalFee = $this->calculator->getTotalFee($term, $amount);
        return (float)number_format($totalFee, 2, '.', '');
    }
}