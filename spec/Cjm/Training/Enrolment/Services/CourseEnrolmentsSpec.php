<?php

namespace spec\Cjm\Training\Enrolment\Services;

use Cjm\Training\Enrolment\Model\ClassSize;
use Cjm\Training\Enrolment\Model\Course;
use Cjm\Training\Enrolment\Model\Courses;
use Cjm\Training\Enrolment\Model\EnrolmentProblem as ModelEnrolmentProblem;
use Cjm\Training\Enrolment\Model\Learner;
use Cjm\Training\Enrolment\Services\CourseEnrolments;
use Cjm\Training\Enrolment\Services\EnrolmentProblem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CourseEnrolmentsSpec extends ObjectBehavior
{
    function let(Courses $courses, Course $course)
    {
        $this->beConstructedWith($courses);
        $courses->findByTitle('behat for dummies')->willReturn($course);
    }

    function it_proposes_a_new_course(Courses $courses)
    {
        $courses->add(
            Course::propose(
                'behat for intermediates',
                ClassSize::between(4, 10)
            )
        )->shouldBecalled();

        $this->propose('behat for intermediates', 4, 10);
    }

    function it_enrols_a_learner_on_a_course(Courses $courses, Course $course)
    {
        $course->enrol(Learner::called('Alice'))->shouldBeCalled();
        $courses->persist($course)->shouldBeCalled();

        $this->enrol('Alice', 'behat for dummies');
    }

    function it_sees_if_a_course_is_viable(Course $course)
    {
        $course->isViable()->willReturn(true);

        $this->isCourseViable('behat for dummies')->shouldReturn(true);
    }

    function it_casts_and_rethrows_handles_enrolment_problems(Course $course)
    {
        $course->enrol(Argument::any())->willThrow(new ModelEnrolmentProblem());

        $this->shouldThrow(EnrolmentProblem::class)->duringEnrol('Alice', 'behat for dummies');
    }
}
