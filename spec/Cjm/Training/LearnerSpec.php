<?php

namespace spec\Cjm\Training;

use Cjm\Training\Learner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LearnerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedCalled('Ciaran');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Learner::class);
    }
}
