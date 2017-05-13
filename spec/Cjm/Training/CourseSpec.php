<?php

namespace spec\Cjm\Training;

use Cjm\Training\ClassSize;
use Cjm\Training\Learner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CourseSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThroughPropose('Course title', ClassSize::between(2,3));
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

        $this->shouldThrow(\Cjm\Training\EnrolmentProblem::class)->duringEnrol(Learner::called('Derek'));
    }
}
