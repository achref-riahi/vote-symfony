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
use AppBundle\Entity\Vote;
use AppBundle\Entity\SubjectOption;


/**
 * Vote controller.
 *
 */
class VoteController extends Controller
{

  /**
   * @Rest\View()
   * @Rest\Post("/vote/{id}")
  */
  public function postSubjectAction(Request $request)
  {
    $subjectoption = $this->get('doctrine')
            ->getRepository('AppBundle:SubjectOption')
            ->findOneById($request->get('id'));

    if (empty($subjectoption)) {
        return new JsonResponse(['message' => 'Option not found'], Response::HTTP_NOT_FOUND);
    }else{
      $vote = new Vote();
      $vote->setSubjectoption($subjectoption);
      $vote->setUser($this->getUser());
      $vote->setDate(new \DateTime("now"));
      $em = $this->getDoctrine()->getManager();
      $em->persist($vote);
      $em->flush();
      return "Vote valide";
    }
  }
}
