<?php

namespace Lukaswhite\PeopleGenerator;

use Lukaswhite\PeopleGenerator\Exceptions\CannotGenerateUniqueEmailException;

class Generator
{

    protected $male;

    protected $female;

    protected $surnames;

    protected $domains;

    protected $emails = [];

    protected $uniqueEmails = true;

    public function __construct()
    {
        $this->male = $this->readLines('male.txt');
        $this->female = $this->readLines('female.txt');
        $this->surnames = $this->readLines('surnames.txt');
        $this->domains = $this->readLines('domains.txt');
    }

    /**
     * Generate a random person.
     *
     * @return Person
     */
    public function generate(string $gender = null): Person
    {
        $gender = $gender ?? $this->randomGender();
        $person = (new Person())
            ->setGender($gender)
            ->setForename($this->randomForename($gender))
            ->setSurname($this->randomSurname())
            ->setDob($this->randomDob())
            ->setPhoto($this->randomPhoto($gender));

        $person->setEmail($this->generateEmail($person));

        return $person;
    }

    /**
     * @return Person
     */
    public function male(): Person
    {
        return $this->generate(Person::MALE);
    }

    /**
     * @return Person
     */
    public function female(): Person
    {
        return $this->generate(Person::FEMALE);
    }

    /**
     * Generate a number of people in bulk.
     *
     * @param int $count
     * @return array
     */
    public function bulk(int $count): array
    {
        return array_map(
            function(int $i) {
                return $this->generate();
            }, range(0, $count - 1)
        );
    }

    public function disableUniqueEmails(): self
    {
        $this->uniqueEmails = false;
        return $this;
    }

    protected function readLines(string $filename): array
    {
        $filepath = sprintf('%s/../data/%s', __DIR__, $filename);
        return array_map(
            function(string $value) {
                return ucfirst(trim(strtolower($value)));
            },
            file($filepath, FILE_IGNORE_NEW_LINES)
        );
    }

    /**
     * Generates an email address for the specified person.
     *
     * It incorporates the user's name in the format [FORENAME].[SURNAME]
     *
     * Note that by default, the generator keeps track of the email addresses it's
     * assigned, to assist you in generating unique identities. This can be disabled
     * using the disableUniqueEmails() method.
     *
     * @param Person $person
     * @return string
     * @throws CannotGenerateUniqueEmailException
     */
    protected function generateEmail(Person $person): string
    {
        shuffle($this->domains);
        $email = '';
        foreach($this->domains as $domain) {
            $email = strtolower(sprintf(
                '%s.%s@%s',
                $person->getForename(),
                $person->getSurname(),
                $domain
            ));
        }

        if(!$this->uniqueEmails) {
            return $email;
        }

        if(!in_array($email, $this->emails)) {
            $this->emails[] = $email;
            return $email;
        }

        throw new CannotGenerateUniqueEmailException();

    }

    protected function randomForename(string $gender = null): string
    {
        if(!empty($gender)) {
            return $gender === Person::MALE ? $this->randomMaleForename() :
                $this->randomFemaleForename();
        }
        return $this->randomForename($this->randomGender());
    }

    protected function randomMaleForename(): string
    {
        return $this->male[array_rand($this->male)];
    }

    protected function randomFemaleForename(): string
    {
        return $this->female[array_rand($this->female)];
    }

    protected function randomSurname(): string
    {
        return $this->surnames[array_rand($this->surnames)];
    }

    protected function randomDomain(): string
    {
        return $this->domains[array_rand($this->domains)];
    }

    protected function randomGender(): string
    {
        return mt_rand(0,1) === 0 ? Person::MALE : Person::FEMALE;
    }

    protected function randomDob(): \DateTime
    {
        $max = (new \DateTime())->sub(new \DateInterval('P18Y'));
        $min = $max
            ->sub(new \DateInterval(sprintf('P%dY', mt_rand(0, 60))));

        return $this->randomDateInRange($min, $max);
    }

    protected function randomDateInRange(\DateTime $start, \DateTime $end): \DateTime
    {
        $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);
        return $randomDate;
    }

    protected function randomPhoto(string $gender): string
    {
        $dir = sprintf('%s/../assets/headshots/%s', __DIR__, $gender);
        $paths = array_map(
            function(string $path) {
                return realpath($path);
            },
            glob(sprintf('%s/*.jpg', $dir))
        );
        return $paths[array_rand($paths)];
    }
}