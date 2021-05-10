<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model;

use Lendable\Interview\Interpolation\Provider\DataProvider;

class Calculator
{
    private $dataProvider;
    private $max;
    private $min;
    private $minFee;
    private $maxFee;
    private $fee;
    private $interpolateVal;

    public function __construct()
    {
        $this->dataProvider = new DataProvider();
    }

    public function getTotalFee(int $term, float $amount): float
    {
        //get min fee and max fee
        //if they are same get the same fee
        //if they are different calculate the equal number for that amount of fee
        //the fee difference must be positive number
        $this->setMax((int)ceil($amount / 1000) * 1000);
        $this->setMin($this->getMax() - 1000);
        $this->setMinFee($this->getDataProvider()->getFeeByAmountAndTerm($this->getMin(), $term));
        $this->setMaxFee($this->getDataProvider()->getFeeByAmountAndTerm($this->getMax(), $term));
        $this->setInterpolateVal(abs($this->getMinFee() - $this->getMaxFee()));

        if ($this->getInterpolateVal() == 0) {
            $this->setFee($this->getMaxFee());
        } else {
            $fairValue = $amount - $this->getMin();
            $fairFee = ($fairValue * $this->getInterpolateVal()) / 1000;
            $this->setFee($this->getMinFee() + $fairFee);
        }
        return $this->getFee();
    }

    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @param int $max
     * @return Calculator
     */
    public function setMax(int $max): Calculator
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @return DataProvider
     */
    public function getDataProvider(): DataProvider
    {
        return $this->dataProvider;
    }

    /**
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }

    /**
     * @param int $min
     * @return Calculator
     */
    public function setMin(int $min): Calculator
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinFee(): int
    {
        return $this->minFee;
    }

    /**
     * @param int $minFee
     * @return Calculator
     */
    public function setMinFee(int $minFee): Calculator
    {
        $this->minFee = $minFee;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxFee(): int
    {
        return $this->maxFee;
    }

    /**
     * @param int $maxFee
     * @return Calculator
     */
    public function setMaxFee(int $maxFee): Calculator
    {
        $this->maxFee = $maxFee;
        return $this;
    }

    /**
     * @return float
     */
    public function getInterpolateVal(): float
    {
        return $this->interpolateVal;
    }

    /**
     * @param float $interpolateVal
     * @return Calculator
     */
    public function setInterpolateVal(float $interpolateVal): Calculator
    {
        $this->interpolateVal = $interpolateVal;
        return $this;
    }

    /**
     * @return float
     */
    public function getFee(): float
    {
        return $this->fee;
    }

    /**
     * @param float $fee
     * @return Calculator
     */
    public function setFee(float $fee): Calculator
    {
        $this->fee = $fee;
        return $this;
    }

}