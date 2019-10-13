<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Contracts\EmployeeInterface;
use App\Domain\Contracts\EmployeeProviderInterface;
use App\Domain\Exceptions\TypeErrorException;

class InMemoryEmployeeProvider implements EmployeeProviderInterface
{
    /**
     * @var EmployeeInterface[]
     */
    private $employees;

    /**
     * InMemoryEmployeeProvider constructor.
     * @param EmployeeInterface[] $employees
     * @throws TypeErrorException
     */
    public function __construct(array $employees)
    {
        foreach ($employees as $employee) {
            if (!$employee instanceof EmployeeInterface) {
                throw new TypeErrorException();
            }
        }

        $this->employees = $employees;
    }

    /**
     * @inheritDoc
     */
    public function getNextEmployee(): ?EmployeeInterface
    {
        return array_pop($this->employees);
    }
}