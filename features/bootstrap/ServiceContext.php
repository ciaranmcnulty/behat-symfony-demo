<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Cjm\Training\Enrolment\Model\Learner;
use Cjm\Training\Enrolment\Services\EnrolmentProblem;

/**
 * Defines application features from the specific context.
 */
class ServiceContext implements Context
{
    private $courseEnrolments;

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
     */
    public function learnerEnrolsOnThisCourse(string $learner)
    {
        $this->courseEnrolments->enrol($learner, $this->course);
    }

    /**
     * @Then this course will not be viable
     */
    public function thisCourseWillNotBeViable()
    {
        assert($this->courseEnrolments->isCourseViable($this->course) == false);
    }
}
