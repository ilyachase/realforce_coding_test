<?php
declare(strict_types=1);

namespace Tests\Support;

use App\Domain\Contracts\EmployeeInterface;
use App\Domain\Models\Employee;
use Faker\Factory;
use Money\Money;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = Factory::create();
    }

    protected function generateEmployee(): EmployeeInterface
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