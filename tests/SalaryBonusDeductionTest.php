<?php

namespace Tests;

use App\Domain\Models\BonusDeductions\CountryTaxDeduction;
use Tests\Support\TestCase;

class SalaryBonusDeductionTest extends TestCase
{
    public function testCountryTaxDeduction()
    {
        $employee = $this->generateEmployee();

        $deductionModel = new CountryTaxDeduction();

        $expectedSalary = $employee->getSalary()->multiply($deductionModel->getTaxMultiplier());

        $employee = $deductionModel->apply($employee);

        $this->assertTrue($expectedSalary->equals($employee->getSalary()));
    }
}