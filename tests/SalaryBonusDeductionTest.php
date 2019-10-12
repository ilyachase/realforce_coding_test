<?php

namespace Tests;

use App\Domain\Models\BonusDeductions\AgeBonus;
use App\Domain\Models\BonusDeductions\CompanyCarUsingDeduction;
use App\Domain\Models\BonusDeductions\CountryTaxDeduction;
use Tests\Support\TestCase;

class SalaryBonusDeductionTest extends TestCase
{
    public function testCountryTaxDeduction()
    {
        $employee = $this->generateEmployee();

        $model = new CountryTaxDeduction();

        if ($employee->getKidsCount() > $model->getKidsCountBorder()) {
            $expectedSalary = $employee->getSalary()->multiply($model->getLowerMultiplier());
        } else {
            $expectedSalary = $employee->getSalary()->multiply($model->getDefaultMultiplier());
        }

        $employee = $model->apply($employee);

        $this->assertTrue($expectedSalary->equals($employee->getSalary()));
    }

    public function testAgeBonus()
    {
        $employee = $this->generateEmployee();

        $model = new AgeBonus();

        $isApplicable = $employee->getAge() > $model->getAgeBorder();

        $this->assertEquals($isApplicable, $model->isApplicable($employee));

        if ($isApplicable) {
            $expectedSalary = $employee->getSalary()->multiply($model->getMultiplier());
            $employee = $model->apply($employee);
            $this->assertTrue($expectedSalary->equals($employee->getSalary()));
        }
    }

    public function testCompanyCarUsingDeduction()
    {
        $employee = $this->generateEmployee();

        $model = new CompanyCarUsingDeduction();

        $isApplicable = $employee->isUsingCompanyCar();

        $this->assertEquals($isApplicable, $model->isApplicable($employee));

        if ($isApplicable) {
            $expectedSalary = $employee->getSalary()->subtract($model->getSubtractMoney());
            $employee = $model->apply($employee);
            $this->assertTrue($expectedSalary->equals($employee->getSalary()));
        }
    }
}