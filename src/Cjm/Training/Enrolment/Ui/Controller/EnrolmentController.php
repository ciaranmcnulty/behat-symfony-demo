<?php

namespace Cjm\Training\Enrolment\Ui\Controller;

use Cjm\Training\Enrolment\Services\CourseEnrolments;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EnrolmentController extends Controller
{
    /**
     * @Route("/courses/{course}", name="courses")
     * @Method("get")
     */
    public function coursesAction(string $course)
    {
        $course = $this->get('cjm.training.enrolment.course_list')->findByTitle($course);

        return $this->render('courses.html.twig', ['course' => $course]);
    }

    /**
     * @Route("/courses/{course}")
     * @Method("post")
     */
    public function enrolAction(string $course, Request $request)
    {
        $name = $request->request->get('name');

        $this->get('cjm.training.enrolment.course_enrolments')
             ->enrol($name, $course);

        return $this->redirectToRoute('courses', ['course'=>$course]);
    }
}
