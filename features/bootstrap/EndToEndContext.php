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
     * @When only :learner enrols on this course
     */
    public function learnerEnrolsOnCourse(string $learner)
    {
        $this->visitPath('/courses/'.$this->course);

        $page = $this->getSession()->getPage();
        $page->fillField('Your name', $learner);
        $page->pressButton('Enrol');
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
     * @Given Alice has already enrolled on this course
     */
    public function aliceHasAlreadyEnrolledOnThisCourse()
    {
        throw new PendingException();
    }

    /**
     * @When Bob enrols on this course
     */
    public function bobEnrolsOnThisCourse()
    {
        throw new PendingException();
    }

    /**
     * @Then this course will be viable
     */
    public function thisCourseWillBeViable()
    {
        throw new PendingException();
    }

    /**
     * @Given Alice, Bob and Charlie have already enrolled on this course
     */
    public function aliceBobAndCharlieHaveAlreadyEnrolledOnThisCourse()
    {
        throw new PendingException();
    }

    /**
     * @When Derek tries to enrol on this course
     */
    public function derekTriesToEnrolOnThisCourse()
    {
        throw new PendingException();
    }

    /**
     * @Then he should not be able to enrol
     */
    public function heShouldNotBeAbleToEnrol()
    {
        throw new PendingException();
    }
}
