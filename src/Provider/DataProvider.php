<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Provider;

use Lendable\Interview\Interpolation\Exception\AmountValidationException;
use Lendable\Interview\Interpolation\Exception\TermValidationException;

class DataProvider
{

    /**
     * @var int[]
     */
    private $feeTable = [
        1000 => [12 => 50, 24 => 70],
        2000 => [12 => 90, 24 => 100],
        3000 => [12 => 90, 24 => 120],
        4000 => [12 => 115, 24 => 160],
        5000 => [12 => 100, 24 => 200],
        6000 => [12 => 120, 24 => 240],
        7000 => [12 => 140, 24 => 280],
        8000 => [12 => 160, 24 => 320],
        9000 => [12 => 180, 24 => 360],
        10000 => [12 => 200, 24 => 400],
        11000 => [12 => 220, 24 => 440],
        12000 => [12 => 240, 24 => 480],
        13000 => [12 => 260, 24 => 520],
        14000 => [12 => 280, 24 => 560],
        15000 => [12 => 300, 24 => 600],
        16000 => [12 => 320, 24 => 640],
        17000 => [12 => 340, 24 => 680],
        18000 => [12 => 360, 24 => 720],
        19000 => [12 => 380, 24 => 760],
        20000 => [12 => 400, 24 => 800],
    ];

    /**
     * @param int $amount
     * @param int $term
     * @param int $fee
     * @return DataProvider
     * @throws AmountValidationException
     * @throws TermValidationException
     */
    public function setFeeByAmountAndTerm(int $amount, int $term, int $fee): DataProvider
    {
        $this->checkParam($amount, $term);
        $this->feeTable[$amount][$term] = $fee;
        return $this;
    }

    /**
     * @param int $amount
     * @param int $term
     * @return bool
     * @throws AmountValidationException
     * @throws TermValidationException
     */
    public function checkParam(int $amount, int $term): bool
    {
        if (!array_key_exists($amount, $this->getFeeTable())) {
            throw new AmountValidationException('Amount doesn\'t exists');
        }
        if (!in_array($term, [12, 24])) {
            throw new TermValidationException('Term doesn\'t exists');
        }
        return true;
    }

    /**
     * @return int[]
     */
    public function getFeeTable(): array
    {
        return $this->feeTable;
    }

    /**
     * @param int $amount
     * @param int $term
     * @return int
     * @throws AmountValidationException
     * @throws TermValidationException
     */
    public function getFeeByAmountAndTerm(int $amount, int $term): int
    {
        $this->checkParam($amount, $term);
        return $this->getFeeTable()[$amount][$term];
    }
}