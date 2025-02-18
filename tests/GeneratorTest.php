<?php

namespace Lukaswhite\PeopleGenerator\tests;

use PHPUnit\Framework\TestCase;
use Lukaswhite\PeopleGenerator\Generator;
use Lukaswhite\PeopleGenerator\Person;

class GeneratorTest extends TestCase
{
    public function test_can_generate_single_person()
    {
        $generator = new Generator();
        $person = $generator->generate();

        $this->assertInstanceOf(Person::class, $person);
        $this->assertNotNull($person->getForename());
        $this->assertNotNull($person->getSurname());
        $this->assertNotNull($person->getEmail());
        $this->assertNotNull($person->getDob());
        $this->assertNotNull($person->getPhoto());
    }

    public function test_email_contains_name()
    {
        $generator = new Generator();
        $person = $generator->generate();

        $parts = explode('@', $person->getEmail());
        $this->assertEquals(
            strtolower(sprintf('%s.%s', $person->getForename(), $person->getSurname())),
            $parts[0]
        );
    }

    public function test_includes_photo()
    {
        $generator = new Generator();
        $person = $generator->generate();

        $this->assertTrue(str_contains($person->getPhoto(), $person->getGender()));
        $this->assertTrue(file_exists($person->getPhoto()));
    }

}