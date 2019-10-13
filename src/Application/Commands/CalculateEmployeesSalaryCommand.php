<?php
declare(strict_types=1);

namespace App\Application\Commands;

use App\Application\Exceptions\InvalidInputException;
use App\Domain\Contracts\EmployeeInterface;
use App\Domain\Models\BonusDeductions\AgeBonus;
use App\Domain\Models\BonusDeductions\CompanyCarUsingDeduction;
use App\Domain\Models\BonusDeductions\CountryTaxDeduction;
use App\Domain\Models\Employee;
use App\Domain\Models\SalaryCalculator;
use App\Infrastructure\Persistence\InMemoryEmployeeProvider;
use Money\Money;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CalculateEmployeesSalaryCommand extends Command
{
    public const ANSWER_YES = 'yes';
    public const ANSWER_NO = 'no';

    protected static $defaultName = 'calculate-salary';

    protected function configure()
    {
        $this
            ->setDescription("Console command to calculate employee's salary.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $employee = $this->getEmployeeFromInput($input, $output);

        $provider = new InMemoryEmployeeProvider([$employee]);

        $salaryCalculator = new SalaryCalculator([
            new CountryTaxDeduction(),
            new AgeBonus(),
            new CompanyCarUsingDeduction(),
        ]);

        $employeeWithNewSalary = $salaryCalculator->calculateSalary($provider);

        $output->writeln("Calculated salary is: " . $employeeWithNewSalary->getSalary()->getAmount());
    }

    private function getEmployeeFromInput(InputInterface $input, OutputInterface $output): EmployeeInterface
    {
        $helper = $this->getHelper('question');

        $output->writeln("Please enter the information of the employee");

        $question = new Question("Name: ");
        $name = $helper->ask($input, $output, $question);

        if (!$name) {
            throw new InvalidInputException();
        }

        $question = new Question("Age: ");
        $age = $helper->ask($input, $output, $question);

        if (!is_numeric($age)) {
            throw new InvalidInputException();
        }

        $age = (int)$age;

        if ($age < 0) {
            throw new InvalidInputException();
        }

        $question = new Question("Kids count: ");
        $kidsCount = $helper->ask($input, $output, $question);

        if (!is_numeric($kidsCount)) {
            throw new InvalidInputException();
        }

        $kidsCount = (int)$kidsCount;

        if ($kidsCount < 0) {
            throw new InvalidInputException();
        }

        $question = new Question("Is using company car (yes, no): ");
        $isUsingCompanyCar = $helper->ask($input, $output, $question);

        if (!$isUsingCompanyCar || !in_array($isUsingCompanyCar, [self::ANSWER_YES, self::ANSWER_NO])) {
            throw new InvalidInputException();
        }

        $isUsingCompanyCar = $isUsingCompanyCar === self::ANSWER_YES;

        $question = new Question("Salary in cents (e.g. 50000 = $500): ");
        $salary = $helper->ask($input, $output, $question);

        if (!is_numeric($salary)) {
            throw new InvalidInputException();
        }

        $salary = (int)$salary;

        if ($salary < 0) {
            throw new InvalidInputException();
        }

        try {
            $salary = Money::USD($salary);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidInputException($e->getMessage());
        }

        return new Employee($name, $age, $kidsCount, $isUsingCompanyCar, $salary);
    }
}