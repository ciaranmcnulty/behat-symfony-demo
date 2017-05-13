<?php

namespace spec\Cjm\Training;

use Cjm\Training\ClassSize;
use Cjm\Training\Course;
use Cjm\Training\Learner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CourseSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThroughPropose('Course title', ClassSize::between(1,3));
    }

    function it_can_enrol_a_learner()
    {
        $this->enrol(Learner::called('Ciaran'));
    }

    function it_is_not_viable_to_start()
    {
        $this->shouldNotBeViable();
    }
}
