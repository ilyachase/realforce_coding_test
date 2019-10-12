<?php
declare(strict_types=1);

namespace Tests;

use App\Domain\Contracts\EmployeeInterface;
use App\Domain\Models\Employee;
use App\Infrastructure\Exceptions\TypeErrorException;
use App\Infrastructure\Persistence\InMemoryEmployeeProvider;
use Money\Money;
use Tests\Support\TestCase;

class EmployeeProviderTest extends TestCase
{
    public function testInMemoryEmployeeProvider()
    {
        $employeesCount = $this->faker->numberBetween(1, 10);
        $employees = [];
        for ($i = 0; $i <= $employeesCount; $i++) {
            $employees[] = $this->generateEmployee();
        }

        $provider = new InMemoryEmployeeProvider($employees);

        $employeesCount = 0;
        while ($provider->getNewEmployee()) {
            $employeesCount++;
        }

        $this->assertEquals(count($employees), $employeesCount);
    }

    public function testInMemoryEmployeeProviderTypesChecking()
    {
        $this->expectException(TypeErrorException::class);
        new InMemoryEmployeeProvider([1, 2, 3]);
    }

    private function generateEmployee(): EmployeeInterface
    {
        return new Employee(
            $this->faker->name,
            $this->faker->numberBetween(0, 80),
            $this->faker->numberBetween(0, 10),
            $this->faker->boolean,
            Money::USD($this->faker->numberBetween(1, 15000))
        );
    }
}