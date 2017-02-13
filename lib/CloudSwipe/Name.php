<?php

namespace CloudSwipe;

class Name
{
    public $firstName, $lastName;

    public function __construct($psNameable)
    {
        $this->firstName = $psNameable->firstname;
        $this->lastName = $psNameable->lastname;
    }

    public function toString()
    {
        return (string) $this;
    }

    public function __toString()
    {
        return implode(" ", [$this->firstName, $this->lastName]);
    }
}
