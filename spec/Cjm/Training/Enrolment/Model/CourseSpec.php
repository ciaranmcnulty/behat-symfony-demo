<?php

namespace spec\Cjm\Training\Enrolment\Model;

use Cjm\Training\Enrolment\Model\ClassSize;
use Cjm\Training\Enrolment\Model\EnrolmentProblem;
use Cjm\Training\Enrolment\Model\Learner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CourseSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThroughPropose('Course title', ClassSize::between(2,3));
    }

    function it_exposes_title()
    {
        $this->getTitle()->shouldReturn('Course title');
    }

    function it_is_not_viable_to_start()
    {
        $this->shouldNotBeViable();
    }

    function it_is_not_viable_if_class_size_is_not_reached()
    {
        $this->enrol(Learner::called('Alice'));
        $this->shouldNotBeViable();
    }

    function it_is_viable_if_class_size_is_reached()
    {
        $this->enrol(Learner::called('Alice'));
        $this->enrol(Learner::called('Bob'));
        $this->shouldBeViable();
    }

    function it_will_not_allow_enrolments_past_maximum_class_size()
    {
        $this->enrol(Learner::called('Alice'));
        $this->enrol(Learner::called('Bob'));
        $this->enrol(Learner::called('Charlie'));

        $this->shouldThrow(EnrolmentProblem::class)->duringEnrol(Learner::called('Derek'));
    }
}
