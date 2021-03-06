<?php

namespace Cjm\Training\Enrolment\Model;

class Learner
{
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function called(string $name)
    {
        return new Learner($name);
    }
}
