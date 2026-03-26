<?php

interface AnimalActions
{
    public function makeSound(): string;
    public function move(): string;
}


abstract class Animal implements AnimalActions
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

trait Swimmable
{
    public function swim(): string
    {
        return "{$this->name} is swimming!<br>";
    }
}

trait Flyable
{
    public function fly(): string
    {
        return "{$this->name} is flying!<br>";
    }
}

class Dog extends Animal
{
    use Swimmable;   

    public function makeSound(): string
    {
        return "{$this->name} says Woof!<br>";
    }

    public function move(): string
    {
        return "{$this->name} runs on land.<br>";
    }
}

class Bird extends Animal
{
    use Flyable;  

    public function makeSound(): string
    {
        return "{$this->name} says Tweet!<br>";
    }

    public function move(): string
    {
        return "{$this->name} hops around.<br>";
    }
}



$dog  = new Dog("Buddy");
$bird = new Bird("Tweety");

echo $dog->makeSound();
echo $dog->move();
echo $dog->swim();
echo "<br>";
echo $bird->makeSound();
echo $bird->move();
echo $bird->fly();
