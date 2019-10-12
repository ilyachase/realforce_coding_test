<?php
declare(strict_types=1);

namespace App\Domain\Models\BonusDeductions;

use App\Domain\Contracts\EmployeeInterface;
use App\Domain\Contracts\SalaryBonusDeductionInterface;

class CountryTaxDeduction implements SalaryBonusDeductionInterface
{
    /** @var float */
    private $taxMultiplier = 0.8;

    /**
     * Country tax is applicable for all employees.
     *
     * @param EmployeeInterface $employee
     * @return bool
     */
    public function isApplicable(EmployeeInterface $employee): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function apply(EmployeeInterface $employee): EmployeeInterface
    {
        $currentSalary = $employee->getSalary();

        $newSalary = $currentSalary->multiply($this->taxMultiplier);

        $employee->setSalary($newSalary);

        return $employee;
    }

    /**
     * Returns current tax multiplier for Country Tax.
     *
     * @return float
     */
    public function getTaxMultiplier(): float
    {
        return $this->taxMultiplier;
    }
}