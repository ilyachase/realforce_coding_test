<?php
declare(strict_types=1);

namespace App\Domain\Contracts;

interface EmployeeProviderInterface
{
    /**
     * Return next employee from collection,
     * or null if no more employees left.
     *
     * @return EmployeeInterface|null
     */
    public function getNextEmployee(): ?EmployeeInterface;
}