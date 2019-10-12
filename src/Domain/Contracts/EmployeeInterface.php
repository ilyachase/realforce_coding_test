<?php
declare(strict_types=1);

namespace App\Domain\Contracts;

use Money\Money;

interface EmployeeInterface
{
    /**
     * Returns employee's name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns employee's age in years.
     *
     * @return int
     */
    public function getAge(): int;

    /**
     * Returns employee's kids count.
     *
     * @return int
     */
    public function getKidsCount(): int;

    /**
     * Returns flag is employee using company car.
     *
     * @return bool
     */
    public function isUsingCompanyCar(): bool;

    /**
     * Returns current salary for employee.
     *
     * @return int
     */
    public function getSalary(): Money;

    /**
     * Sets new salary for employee.
     *
     * @param Money $money
     */
    public function setSalary(Money $money): void;
}