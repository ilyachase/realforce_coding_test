<?php

namespace Tests;

use App\Domain\Models\Employee;
use Money\Money;
use Tests\Support\TestCase;

class EmployeeTest extends TestCase
{
    public function testEmployeeModel()
    {
        $name = $this->faker->name;
        $age = $this->faker->numberBetween(0, 80);
        $kidsCount = $this->faker->numberBetween(0, 10);
        $isUsingCompanyCar = $this->faker->boolean;
        $salary = Money::USD($this->faker->numberBetween(1, 15000));

        $employee = new Employee($name, $age, $kidsCount, $isUsingCompanyCar, $salary);

        $this->assertEquals($name, $employee->getName());
        $this->assertEquals($age, $employee->getAge());
        $this->assertEquals($kidsCount, $employee->getKidsCount());
        $this->assertEquals($isUsingCompanyCar, $employee->isUsingCompanyCar());
        $this->assertTrue($salary->equals($employee->getSalary()));
    }
}
