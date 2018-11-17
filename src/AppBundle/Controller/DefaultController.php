<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SubjectType;
use AppBundle\Entity\Subject;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $subject =  new Subject();
         $form = $this->createForm(SubjectType::class, $subject);

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form'=>$form->createView(),
        ]);
    }
}
