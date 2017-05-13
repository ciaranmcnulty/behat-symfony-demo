<?php

namespace spec\Cjm\Training;

use Cjm\Training\ClassSize;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClassSizeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedBetween(2,3);
    }

    function it_allows_valid_amounts()
    {
        $this->allows(2)->shouldReturn(true);
    }

    function it_does_not_allows_sizes_below_the_range()
    {
        $this->allows(1)->shouldReturn(false);
    }
}
