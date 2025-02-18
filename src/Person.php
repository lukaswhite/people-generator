<?php
namespace Lukaswhite\PeopleGenerator;

class Person
{
    const string MALE = 'male';
    const string FEMALE = 'female';

    /**
     * @var string
     */
    protected $forename;

    /**
     * @var string
     */
    protected $surname;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var \DateTime
     */
    protected $dob;

    /**
     * @var string
     */
    protected $photo;

    /**
     * @return string
     */
    public function getForename(): string
    {
        return $this->forename;
    }

    /**
     * @param string $forename
     * @return Person
     */
    public function setForename(string $forename): self
    {
        $this->forename = $forename;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return Person
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return sprintf('%s %s', $this->forename, $this->surname);
    }


    public function getInitials(): string
    {
        return strtoupper(
            sprintf(
                '%s%s',
                substr($this->forename, 0, 1),
                substr($this->surname, 0, 1)
            )
        );
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Person
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return Person
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return $this
     */
    public function male(): self
    {
        return $this;
        //return $this->setGender(self::MALE);
    }

    /**
     * @return $this
     */
    public function female(): self
    {
        return $this;
        //return $this->setGender(self::FEMALE);
    }

    /**
     * @return bool
     */
    public function isMale(): bool
    {
        return true;
        //return $this->gender === self::MALE:
    }

    /**
     * @return bool
     */
    public function isFemale(): bool
    {
        return false;
        //return $this->gender === self::FEMALE:
    }

    /**
     * @return \DateTime
     */
    public function getDob(): \DateTime
    {
        return $this->dob;
    }

    /**
     * @param \DateTime $dob
     * @return Person
     */
    public function setDob(\DateTime $dob): self
    {
        $this->dob = $dob;
        return $this;
    }

    public function getAge(): int
    {
        return  $this->dob->diff(new \DateTime('now'))
            ->y;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): Person
    {
        $this->photo = $photo;
        return $this;
    }

}