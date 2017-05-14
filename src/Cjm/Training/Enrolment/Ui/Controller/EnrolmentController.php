<?php

namespace Cjm\Training\Enrolment\Ui\Controller;

use Cjm\Training\Enrolment\Services\CourseEnrolments;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class EnrolmentController extends Controller
{
    /**
     * @Route("/courses/{course}")
     */
    public function coursesAction(string $course)
    {
        $course = $this->get('cjm.training.enrolment.course_list')->findByTitle($course);

        return $this->render('courses.html.twig', ['course' => $course]);
    }
}
