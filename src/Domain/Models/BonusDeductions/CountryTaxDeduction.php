<?php
declare(strict_types=1);

namespace App\Domain\Models\BonusDeductions;

use App\Domain\Contracts\EmployeeInterface;
use App\Domain\Contracts\SalaryBonusDeductionInterface;

class CountryTaxDeduction implements SalaryBonusDeductionInterface
{
    /**
     * Default multiplier for Country Tax.
     *
     * @var float
     */
    private $defaultMultiplier = 0.8;

    /**
     * Lower multiplier for Country Tax.
     *
     * @var float
     */
    private $lowerMultiplier = 0.82;

    /**
     * Border kids count for lower Tax multiplier.
     *
     * @var int
     */
    private $kidsCountBorder = 2;

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

        if ($employee->getKidsCount() > $this->kidsCountBorder) {
            $multiplier = $this->lowerMultiplier;
        } else {
            $multiplier = $this->defaultMultiplier;
        }

        $newSalary = $currentSalary->multiply($multiplier);

        $employee->setSalary($newSalary);

        return $employee;
    }

    /**
     * Returns current default tax multiplier for Country Tax.
     *
     * @return float
     */
    public function getDefaultMultiplier(): float
    {
        return $this->defaultMultiplier;
    }

    /**
     * Returns current lower tax multiplier for Country Tax
     * for employees with more than X kids.
     *
     * @return float
     */
    public function getLowerMultiplier(): float
    {
        return $this->lowerMultiplier;
    }

    /**
     * Returns current kids count border for lower multiplier
     * for Country Tax.
     *
     * @return int
     */
    public function getKidsCountBorder(): int
    {
        return $this->kidsCountBorder;
    }
}