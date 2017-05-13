<?php

namespace spec\Cjm\Training\Enrolment\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClassSizeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedBetween(2,3);
    }

    function it_shows_class_is_viable_above_minimum_size()
    {
        $this->shouldBeViable(2);
    }

    function it_shows_class_is_not_viable_below_minimum_size()
    {
        $this->shouldNotBeViable(1);
    }

    function it_shows_when_there_is_still_capacity()
    {
        $this->shouldHaveMoreCapacity(2);
    }

    function it_shows_when_capacity_is_reached()
    {
        $this->shouldNotHaveMoreCapacity(3);
    }
}
