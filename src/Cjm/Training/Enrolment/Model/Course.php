<?php

namespace Cjm\Training\Enrolment\Model;

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

    public static function propose(string $title, ClassSize $classSize) : Course
    {
        return new Course($title, $classSize);
    }

    public function enrol(Learner $learner) : void
    {
        if (!$this->classSize->hasMoreCapacity($this->learners)) {
            throw new EnrolmentProblem('Class is already at capacity');
        }

        $this->learners++;
    }

    public function isViable() : bool
    {
        return $this->classSize->isViable($this->learners);
    }

    public function getTitle() : string
    {
        return $this->title;
    }
}
