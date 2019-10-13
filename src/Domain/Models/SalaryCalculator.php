<?php
declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Contracts\EmployeeInterface;
use App\Domain\Contracts\EmployeeProviderInterface;
use App\Domain\Contracts\SalaryBonusDeductionInterface;
use App\Domain\Contracts\SalaryCalculatorInterface;
use App\Domain\Exceptions\TypeErrorException;

class SalaryCalculator implements SalaryCalculatorInterface
{
    /**
     * @var SalaryBonusDeductionInterface[]
     */
    private $bonusesAndDeductions;

    /**
     * @inheritDoc
     */
    public function __construct(array $bonusesAndDeductions)
    {
        foreach ($bonusesAndDeductions as $bonusesOrDeduction) {
            if (!$bonusesOrDeduction instanceof SalaryBonusDeductionInterface) {
                throw new TypeErrorException();
            }
        }

        $this->bonusesAndDeductions = $bonusesAndDeductions;
    }

    /**
     * @inheritDoc
     */
    public function calculateSalary(EmployeeProviderInterface $provider): EmployeeInterface
    {
        $employee = $provider->getNextEmployee();

        foreach ($this->bonusesAndDeductions as $bonusesOrDeduction) {
            if ($bonusesOrDeduction->isApplicable($employee)) {
                $employee = $bonusesOrDeduction->apply($employee);
            }
        }

        return $employee;
    }
}