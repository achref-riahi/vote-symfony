<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use AppBundle\Entity\Subject;
use AppBundle\Form\SubjectType;

/**
 * Subject controller.
 *
 */
class SubjectController extends Controller
{
  /**
   * @Rest\View()
   * @Rest\Get("/subjects")
   */
  public function getSubjectsAction(Request $request)
  {
      $subjects = $this->get('doctrine')
              ->getRepository('AppBundle:Subject')
              ->findAll();

      return $subjects;
  }

  /**
    * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"subject"})
    * @Rest\Post("/subject")
    */
  public function postSubjectAction(Request $request)
  {
      $subject = new Subject();
      $form = $this->createForm(SubjectType::class, $subject);

      $form->submit($request->request->all()); // Validation des données

      if ($form->isValid()) {

        $em = $this->getDoctrine()->getManager();
        foreach ($subject->getSubjectoptions() as $option) {
                $option->setSubject($subject);
                $em->persist($option);
        }
        $em->persist($subject);
        $em->flush();
        return $subject;
      } else {
        return $form;
      }
  }
}
