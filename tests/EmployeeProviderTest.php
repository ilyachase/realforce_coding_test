<?php
declare(strict_types=1);

namespace Tests;

use App\Infrastructure\Exceptions\TypeErrorException;
use App\Infrastructure\Persistence\InMemoryEmployeeProvider;
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
}