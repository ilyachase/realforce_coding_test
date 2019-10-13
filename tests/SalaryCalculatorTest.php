<?php
declare(strict_types=1);

namespace Tests;

use App\Domain\Exceptions\TypeErrorException;
use App\Domain\Models\BonusDeductions\AgeBonus;
use App\Domain\Models\BonusDeductions\CompanyCarUsingDeduction;
use App\Domain\Models\BonusDeductions\CountryTaxDeduction;
use App\Domain\Models\Employee;
use App\Domain\Models\SalaryCalculator;
use App\Infrastructure\Persistence\InMemoryEmployeeProvider;
use Money\Money;
use Tests\Support\TestCase;

class SalaryCalculatorTest extends TestCase
{
    public function testSalaryCalculatorTypesChecking()
    {
        $this->expectException(TypeErrorException::class);
        new SalaryCalculator([1, 2, 3]);
    }

    public function testSalaryCalculator()
    {
        $expectedSalariesAndEmployees = [
            480000 => new Employee("Alice", 26, 2, false, Money::USD(600000)),
            292400 => new Employee("Bob", 52, 0, true, Money::USD(400000)),
            360000 => new Employee("Charlie", 36, 3, true, Money::USD(500000)),
        ];

        $salaryCalculator = new SalaryCalculator([
            new CountryTaxDeduction(),
            new AgeBonus(),
            new CompanyCarUsingDeduction(),
        ]);

        foreach ($expectedSalariesAndEmployees as $expectedSalaryAmount => $employee) {
            $provider = new InMemoryEmployeeProvider([$employee]);

            $employeeWithNewSalary = $salaryCalculator->calculateSalary($provider);

            $this->assertTrue(Money::USD($expectedSalaryAmount)->equals($employeeWithNewSalary->getSalary()));
        }
    }
}