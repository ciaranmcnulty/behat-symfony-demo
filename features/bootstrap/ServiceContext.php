<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Cjm\Training\Enrolment\Services\EnrolmentProblem;

/**
 * Defines application features from the specific context.
 */
class ServiceContext implements Context
{
    private $courseEnrolments;
    private $enrolmentProblem;

    public function __construct(
        \Cjm\Training\Enrolment\Services\CourseEnrolments $courseEnrolments
    )
    {
        $this->courseEnrolments = $courseEnrolments;
    }

    /**
     * @Given :course was proposed with a class size of :min to :max people
     */
    public function wasProposedWithAClassSizeOfToPeople(string $course, int $min, int $max)
    {
        $this->course = $course;
        $this->courseEnrolments->propose($course, $min, $max);
    }

    /**
     * @When (only) :learner enrols on this course
     * @Given :learner has already enrolled on this course
     */
    public function learnerEnrolsOnThisCourse(string $learner)
    {
        $this->courseEnrolments->enrol($learner, $this->course);
    }

    /**
     * @Given :learner1, :learner2 and :learner3 have already enrolled on this course
     */
    public function learnersHaveAlreadyEnrolledOnThisCourse(
        string $learner1,
        string $learner2,
        string $learner3
    )
    {
        $this->courseEnrolments->enrol($learner1, $this->course);
        $this->courseEnrolments->enrol($learner2, $this->course);
        $this->courseEnrolments->enrol($learner3, $this->course);
    }

    /**
     * @When :learner tries to enrol on this course
     */
    public function learnerTriestToEnrolOnThisCourse(string $learner)
    {
        try {
            $this->courseEnrolments->enrol($learner, $this->course);
        }
        catch(\Exception $e) {
            $this->enrolmentProblem = $e;
        }
    }

    /**
     * @Then this course will not be viable
     */
    public function thisCourseWillNotBeViable()
    {
        assert($this->courseEnrolments->isCourseViable($this->course) == false);
    }

    /**
     * @Then this course will be viable
     */
    public function thisCourseWillBeViable()
    {
        assert($this->courseEnrolments->isCourseViable($this->course) == true);
    }

    /**
     * @Then he should not be able to enrol
     */
    public function heShouldNotBeAbleToEnrol()
    {
        assert($this->enrolmentProblem instanceof EnrolmentProblem);
    }

}
