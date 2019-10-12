<?php
declare(strict_types=1);

namespace App\Domain\Models\BonusDeductions;

use App\Domain\Contracts\EmployeeInterface;
use App\Domain\Contracts\SalaryBonusDeductionInterface;
use Money\Money;

class CompanyCarUsingDeduction implements SalaryBonusDeductionInterface
{
    private $subtractMoney;

    public function __construct()
    {
        $this->subtractMoney = Money::USD(50000);
    }

    /**
     * @inheritDoc
     */
    public function isApplicable(EmployeeInterface $employee): bool
    {
        return $employee->isUsingCompanyCar();
    }

    /**
     * @inheritDoc
     */
    public function apply(EmployeeInterface $employee): EmployeeInterface
    {
        $currentSalary = $employee->getSalary();

        $newSalary = $currentSalary->subtract($this->subtractMoney);

        $employee->setSalary($newSalary);

        return $employee;
    }

    /**
     * Returns current subtraction amount for using company car.
     *
     * @return Money
     */
    public function getSubtractMoney(): Money
    {
        return $this->subtractMoney;
    }
}