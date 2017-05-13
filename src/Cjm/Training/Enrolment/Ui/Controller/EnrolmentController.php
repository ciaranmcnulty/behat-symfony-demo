<?php

namespace Cjm\Training\Enrolment\Ui\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class EnrolmentController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return new Response('hello world');
    }
}
