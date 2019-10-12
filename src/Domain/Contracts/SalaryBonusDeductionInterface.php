<?php
declare(strict_types=1);

namespace App\Domain\Contracts;

interface SalaryBonusDeductionInterface
{
    /**
     * Returns flag is bonus or deduction applicable to given employee.
     *
     * @param EmployeeInterface $employee
     * @return bool
     */
    public function isApplicable(EmployeeInterface $employee): bool;

    /**
     * Apply changes to employee.
     * This method MAY change employee's fields (i.e. salary).
     *
     * @param EmployeeInterface $employee
     * @return EmployeeInterface
     */
    public function apply(EmployeeInterface $employee): EmployeeInterface;
}