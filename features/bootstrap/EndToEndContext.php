<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Defines application features from the specific context.
 */
class EndToEndContext extends \Behat\MinkExtension\Context\RawMinkContext
{
    private $courseEnrolments;
    private $entityManager;
    private $course;
    private $enrolmentProblem;

    /**
     * UiContext constructor.
     * @param \Cjm\Training\Enrolment\Services\CourseEnrolments $courseEnrolments
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(
        \Cjm\Training\Enrolment\Services\CourseEnrolments $courseEnrolments,
        \Doctrine\ORM\EntityManager $entityManager
    )
    {
        $this->courseEnrolments = $courseEnrolments;
        $this->entityManager = $entityManager;
    }

    /**
     * @beforeScenario
     */
    public function createSchema()
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $tool = new SchemaTool($this->entityManager);
            $tool->dropSchema($metadata);
            $tool->createSchema($metadata);
        }
    }

    /**
     * @Given :title was proposed with a class size of :min to :max people
     */
    public function wasProposedWithAClassSizeOfToPeople($title, $min, $max)
    {
        $this->course = $title;
        $this->courseEnrolments->propose($title, $min, $max);
    }

    /**
     * @When (only) :learner enrols on this course
     */
    public function learnerEnrolsOnCourse(string $learner)
    {
        $this->visitPath('/courses/'.$this->course);

        $page = $this->getSession()->getPage();
        $page->fillField('Your name', $learner);
        $page->pressButton('Enrol');
    }

    /**
     * @Given :learner has already enrolled on this course
     */
    public function learnerHasAlreadyEnrolledOnThisCourse(string $learner)
    {
        $this->courseEnrolments->enrol($learner, $this->course);
    }

    /**
     * @Then this course will not be viable
     */
    public function thisCourseWillNotBeViable()
    {
        $this->visitPath('/courses/'.$this->course);

        $this->assertSession()->elementExists('css', '#not-viable-warning');
    }

    /**
     * @Then this course will be viable
     */
    public function thisCourseWillBeViable()
    {
        $this->visitPath('/courses/'.$this->course);

        $this->assertSession()->elementNotExists('css', '#not-viable-warning');
    }

    /**
     * @Given :learner1, :learner2 and :learner3 have already enrolled on this course
     */
    public function learnersHaveAlreadyEnrolledOnThisCourse($learner1, $learner2, $learner3)
    {
        $this->courseEnrolments->enrol($learner1, $this->course);
        $this->courseEnrolments->enrol($learner2, $this->course);
        $this->courseEnrolments->enrol($learner3, $this->course);
    }

    /**
     * @When :learner tries to enrol on this course
     */
    public function learnerTriesToEnrolOnThisCourse(string $learner)
    {
        $this->visitPath('/courses/'.$this->course);

        $page = $this->getSession()->getPage();

        try {
            $page->fillField('Your name', $learner);
            $page->pressButton('Enrol');
        }
        catch (\Behat\Mink\Exception\Exception $e) {
            $this->enrolmentProblem = $e;
        }
    }

    /**
     * @Then he should not be able to enrol
     */
    public function heShouldNotBeAbleToEnrol()
    {
        assert($this->enrolmentProblem instanceof \Behat\Mink\Exception\Exception);
        $this->assertSession()->elementTextContains('css', '#enrolment p', 'Enrolment is closed');
    }
}
