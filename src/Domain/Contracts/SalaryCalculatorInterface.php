<?php
declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Exceptions\TypeErrorException;

interface SalaryCalculatorInterface
{
    /**
     * SalaryCalculatorInterface constructor.
     * Saves all bonuses and deductions for further usage.
     *
     * @param SalaryBonusDeductionInterface[] $bonusesAndDeductions
     * @throws TypeErrorException if wrong instances given.
     */
    public function __construct(array $bonusesAndDeductions);

    /**
     * Calculates salary for the next employee in collection.
     * MUST apply all applicable bonuses and deductions to the employee.
     *
     * @param EmployeeProviderInterface $provider
     * @return EmployeeInterface
     */
    public function calculateSalary(EmployeeProviderInterface $provider): EmployeeInterface;
}