<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Cjm\Training\Enrolment\Model\ClassSize;
use Cjm\Training\Enrolment\Model\Course;
use Cjm\Training\Enrolment\Model\EnrolmentProblem;
use Cjm\Training\Enrolment\Model\Learner;

/**
 * Tests domain objects directly
 */
class DomainContext implements Context
{
    private $course;
    private $enrolmentProblem;

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
     * @When :learner tries to enrol on this course
     */
    public function learnerTriesToEnrolOnCourse(Learner $learner)
    {
        try {
            $this->course->enrol($learner);
        }
        catch (\Exception $e)
        {
            $this->enrolmentProblem = $e;
        }
    }

    /**
     * @Given :learner1, :learner2 and :learner3 have already enrolled on this course
     */
    public function learnersHaveAlreadyEnrolledOnThisCourse(
        Learner $learner1,
        Learner $learner2,
        Learner $learner3
    )
    {
        $this->course->enrol($learner1);
        $this->course->enrol($learner2);
        $this->course->enrol($learner3);
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

    /**
     * @Then (s)he should not be able to enrol
     */
    public function learnerShouldNotBeAbleToEnrol()
    {
        assert($this->enrolmentProblem instanceof EnrolmentProblem);
    }
}
