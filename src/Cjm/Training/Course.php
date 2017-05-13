<?php

namespace Cjm\Training;

class Course
{
    private $title;
    private $classSize;
    private $learners = 0;

    private function __construct(string $title, ClassSize $classSize)
    {
        $this->title = $title;
        $this->classSize = $classSize;
    }

    public static function propose(string $title, ClassSize $classSize)
    {
        return new Course($title, $classSize);
    }

    public function enrol(Learner $learner)
    {
        $this->learners++;
    }

    public function isViable()
    {
        return $this->classSize->allows($this->learners);
    }
}
