<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Cjm\Training\ClassSize;
use Cjm\Training\Course;
use Cjm\Training\Learner;

/**
 * Tests domain objects directly
 */
class DomainContext implements Context
{
    private $course;

    /** @Transform */
    public function transformLearner(string $name) : Learner
    {
        return Learner::called($name);
    }

    /**
     * @Given :courseTitle was proposed with a class size of :min to :max people
     */
    public function courseWasProposedWithAClassSizeOfToPeople(string $courseTitle, int $min, int $max)
    {
        $this->course = Course::propose(
            $courseTitle,
            ClassSize::between($min, $max)
        );
    }

    /**
     * @When (only) :learner enrols on this course
     * @Given :learner has already enrolled on this course
     */
    public function learnerEnrolsOnCourse(Learner $learner)
    {
        $this->course->enrol($learner);
    }

    /**
     * @Then this course will not be viable
     */
    public function thisCourseWillNotBeViable()
    {
        assert($this->course->isViable() == false);
    }

    /**
     * @Then this course will be viable
     */
    public function thisCourseWillBeViable()
    {
        assert($this->course->isViable() == true);
    }
}
