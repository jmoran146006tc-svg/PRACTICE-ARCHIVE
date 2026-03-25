<?php
class Employee
{
    private $name;
    const COMPANY_NAME = "ABC Corporation";

    function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

class FullTimeEmployee extends Employee
{

    private $monthlySalary;

    public function __construct($name, $monthlySalary)
    {
        parent::__construct($name);
        $this->monthlySalary = (float) $monthlySalary;
    }

    public function getSalary()
    {
        return $this->monthlySalary;
    }

    public function getDetails()
    {

        return "Full Time Employee:<br>Company: " . parent::COMPANY_NAME . " <br>Name: " . parent::getName() . "<br>Salary: " . $this->monthlySalary;
    }
}


class PartTimeEmployee extends Employee
{
    private $hourlyRate;
    private $hoursWorked;

    public function __construct($name, $hourlyRate, $hoursWorked)
    {
        parent::__construct($name);
        $this->hourlyRate = (float) $hourlyRate;
        $this->hoursWorked = (int) $hoursWorked;
    }

    public function getSalary()
    {
        return (float) $this->hourlyRate * $this->hoursWorked;
    }

    public function getDetails()
    {

        return "Part Time Employee:<br>Company: " . parent::COMPANY_NAME . " <br>Name: " . parent::getName() . "<br>Salary: " . $this->getSalary();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP PHP</title>
</head>

<body>
    <?php

    $emp = new FullTimeEmployee("James A Eunice", 45999.99);
    $part = new PartTimeEmployee("Lamer M. Makkari", 23.99,45.5);

    echo $emp->getDetails();
    echo "<br><br>";
    echo $part->getDetails();
    
    ?>

</body>

</html>