<?php
declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Contracts\EmployeeInterface;
use Money\Money;

class Employee implements EmployeeInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $age;
    /**
     * @var int
     */
    private $kidsCount;
    /**
     * @var bool
     */
    private $isUsingCompanyCar;
    /**
     * @var Money
     */
    private $salary;

    public function __construct(string $name, int $age, int $kidsCount, bool $isUsingCompanyCar, Money $salary)
    {
        $this->name = $name;
        $this->age = $age;
        $this->kidsCount = $kidsCount;
        $this->isUsingCompanyCar = $isUsingCompanyCar;
        $this->salary = $salary;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @inheritDoc
     */
    public function getKidsCount(): int
    {
        return $this->kidsCount;
    }

    /**
     * @inheritDoc
     */
    public function isUsingCompanyCar(): bool
    {
        return $this->isUsingCompanyCar;
    }

    /**
     * @inheritDoc
     */
    public function getSalary(): Money
    {
        return $this->salary;
    }

    /**
     * @inheritDoc
     */
    public function setSalary(Money $money): void
    {
        $this->salary = $money;
    }
}