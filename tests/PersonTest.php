<?php

namespace Lukaswhite\PeopleGenerator\tests;

use PHPUnit\Framework\TestCase;
use Lukaswhite\PeopleGenerator\Person;

class PersonTest extends TestCase
{
    public function test_can_set_and_get_names()
    {
        $person = new Person();
        $person
            ->setForename('Joe')
            ->setSurname('Bloggs');


        $this->assertEquals('Joe', $person->getForename());
        $this->assertEquals('Bloggs', $person->getSurname());
        $this->assertEquals('Joe Bloggs', $person->getName());
        $this->assertEquals('JB', $person->getInitials());
    }

}