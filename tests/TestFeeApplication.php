<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Tests;

use Lendable\Interview\Interpolation\Exception\AmountValidationException;
use Lendable\Interview\Interpolation\Exception\TermValidationException;
use Lendable\Interview\Interpolation\FeeApplication;
use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Provider\DataProvider;
use PHPUnit\Framework\TestCase;

class TestFeeApplication extends TestCase
{
    protected $feeApp;
    protected $dataProvider;

    public function testCalculate24Months()
    {
        $loanApplication = new LoanApplication(24, 2750);
        $this->assertEquals(115, $this->feeApp->calculate($loanApplication));
    }

    public function testCalculate24MonthsGetsIntReturnsFloat()
    {
        $loanApplication = new LoanApplication(24, 2745);
        $this->assertEquals(114.9, $this->feeApp->calculate($loanApplication));
    }

    public function testCalculate24MonthsGetsFloatReturnsFloat()
    {
        $loanApplication = new LoanApplication(24, 2755.85);
        $this->assertEquals(115.12, $this->feeApp->calculate($loanApplication));
    }

    public function testCalculate12Months()
    {
        $loanApplication = new LoanApplication(12, 2750);
        $this->assertEquals(90, $this->feeApp->calculate($loanApplication));
    }

    public function testCalculate12MonthsGetsIntReturnsFloat()
    {
        $loanApplication = new LoanApplication(12, 12375);
        $this->assertEquals(247.5, $this->feeApp->calculate($loanApplication));
    }

    public function testCalculate12MonthsGetsFloatReturnsFloat()
    {
        $loanApplication = new LoanApplication(12, 8315.60);
        $this->assertEquals(166.31, $this->feeApp->calculate($loanApplication));
    }

    public function testCalculate12MonthsFloatValueEffectsFee()
    {
        $loanApplication = new LoanApplication(12, 4500);
        $this->assertEquals(122.5, $this->feeApp->calculate($loanApplication));
        $loanApplication = new LoanApplication(12, 4500.80);
        $this->assertEquals(122.51, $this->feeApp->calculate($loanApplication));
    }

    public function testExceptionForTerm()
    {
        $loanApplication = new LoanApplication(13, 19250);
        $this->expectException(TermValidationException::class);
        $this->feeApp->calculate($loanApplication);
    }

    public function testExceptionForAmount()
    {
        $loanApplication = new LoanApplication(12, 50);
        $this->expectException(AmountValidationException::class);
        $this->feeApp->calculate($loanApplication);
    }

    public function testExceptionForAmountIsNotMultipleOf5()
    {
        $loanApplication = new LoanApplication(12, 5003);
        $this->expectException(AmountValidationException::class);
        $this->feeApp->calculate($loanApplication);
    }

    public function testDataProviderAmountDoesntExistsForSetter()
    {
        $this->expectException(AmountValidationException::class);
        $this->dataProvider->setFeeByAmountAndTerm(100, 24, 100);
    }

    public function testDataProviderTermDoesntExistsForSetter()
    {
        $this->expectException(TermValidationException::class);
        $this->dataProvider->setFeeByAmountAndTerm(1000, 15, 100);
    }

    public function testDataProviderAmountDoesntExistsForGetter()
    {
        $this->expectException(AmountValidationException::class);
        $this->dataProvider->getFeeByAmountAndTerm(100, 24);
    }

    public function testDataProviderTermDoesntExistsForGetter()
    {
        $this->expectException(TermValidationException::class);
        $this->dataProvider->getFeeByAmountAndTerm(1000, 15);
    }

    public function testDataProviderAmountTermExistsForSetter()
    {
        $this->assertInstanceOf(DataProvider::class, $this->dataProvider->setFeeByAmountAndTerm(1000, 24, 100));
    }

    public function testDataProviderAmountTermExistsForGetter()
    {
        $this->assertNotNull($this->dataProvider->getFeeByAmountAndTerm(1000, 24));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->feeApp = new FeeApplication();
        $this->dataProvider = new DataProvider();
    }
}