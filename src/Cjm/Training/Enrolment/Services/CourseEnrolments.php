<?php

namespace Cjm\Training\Enrolment\Services;

use Cjm\Training\Enrolment\Model\ClassSize;
use Cjm\Training\Enrolment\Model\Course;
use Cjm\Training\Enrolment\Model\Courses;
use Cjm\Training\Enrolment\Model\EnrolmentProblem as ModelEnrolmentProblem;
use Cjm\Training\Enrolment\Model\Learner;
use Cjm\Training\Enrolment\Services\EnrolmentProblem;

class CourseEnrolments
{
    private $courses;

    public function __construct(Courses $courses)
    {
        $this->courses = $courses;
    }

    public function propose(string $title, int $minimum, int $maximum)
    {
        $this->courses->add(
            Course::propose(
                $title,
                ClassSize::between($minimum, $maximum)
            )
        );
    }

    public function enrol(string $learnerName, string $title)
    {
        $course = $this->courses->findByTitle($title);

        try {
            $course->enrol(Learner::called($learnerName));
        }
        catch (ModelEnrolmentProblem $e)
        {
            throw new EnrolmentProblem('You cannot enrol this learner', 0, $e);
        }

        $this->courses->persist($course);
    }

    public function isCourseViable(string $title)
    {
        $course = $this->courses->findByTitle($title);

        return $course->isViable();
    }
}
