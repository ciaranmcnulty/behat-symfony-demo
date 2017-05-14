<?php

namespace Cjm\Training\Enrolment\Services;

use Cjm\Training\Enrolment\Model\Course;
use Cjm\Training\Enrolment\Model\Courses;

class CourseList
{
    private $courses;

    public function __construct(Courses $courses)
    {
        $this->courses = $courses;
    }

    public function findByTitle($title) : ?CourseView
    {
        if(!$course = $this->courses->findByTitle($title)) {
            return null;
        }

        $view = new CourseView;
        $view->title = $course->getTitle();
        $view->viable = $course->isViable();
        $view->canEnrol = $course->canAcceptEnrolments();

        return $view;
    }
}
