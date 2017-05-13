<?php

namespace spec\Cjm\Training;

use Cjm\Training\ClassSize;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClassSizeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedBetween(1,3);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ClassSize::class);
    }
}
