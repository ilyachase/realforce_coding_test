<?php
declare(strict_types=1);

namespace App\Domain\Models\BonusDeductions;

use App\Domain\Contracts\EmployeeInterface;
use App\Domain\Contracts\SalaryBonusDeductionInterface;

class AgeBonus implements SalaryBonusDeductionInterface
{
    /**
     * @var int
     */
    private $ageBorder = 50;

    /**
     * @var float
     */
    private $multiplier = 1.07;

    /**
     * @inheritDoc
     */
    public function isApplicable(EmployeeInterface $employee): bool
    {
        return $employee->getAge() > $this->ageBorder;
    }

    /**
     * @inheritDoc
     */
    public function apply(EmployeeInterface $employee): EmployeeInterface
    {
        $currentSalary = $employee->getSalary();

        $newSalary = $currentSalary->multiply($this->multiplier);

        $employee->setSalary($newSalary);

        return $employee;
    }

    /**
     * Returns current age border for age bonus.
     *
     * @return int
     */
    public function getAgeBorder(): int
    {
        return $this->ageBorder;
    }

    /**
     * Returns current bonus multiplier for age bonus.
     *
     * @return float
     */
    public function getMultiplier(): float
    {
        return $this->multiplier;
    }
}