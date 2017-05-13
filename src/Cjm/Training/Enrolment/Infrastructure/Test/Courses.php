<?php

namespace Cjm\Training\Enrolment\Infrastructure\Test;

use Cjm\Training\Enrolment\Model\Course;

class Courses implements \Cjm\Training\Enrolment\Model\Courses
{
    public function add(Course $course) : void
    {
        $p = (new \ReflectionClass($course))->getProperty('title');
        $p->setAccessible(true);
        $title = $p->getValue($course);

        $this->courses[$title] = $course;
    }

    public function findByTitle(string $title): Course
    {
        return $this->courses[$title];
    }

    public function persist(Course $course): void
    {
        // not needed in-memory
    }
}
