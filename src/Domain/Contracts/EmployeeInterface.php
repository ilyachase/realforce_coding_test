<?php
declare(strict_types=1);

namespace App\Domain\Contracts;

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
}