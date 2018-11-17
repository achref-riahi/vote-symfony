<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;

class RegistrationController extends Controller
{

  /**
    * @Rest\View(statusCode=Response::HTTP_CREATED)
    * @Rest\Post("/register")
    */
  public function postUserAction(Request $request)
  {

      if($request->request->get('username') and $request->request->get('password') and $request->request->get('email')){
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEmail($request->request->get('email'));
        $user->setUsername($request->request->get('username'));
        $user->setPlainPassword($request->request->get('password'));
        $user->setEnabled(true);
        $userManager->updateUser($user, true);
        return "Votre compte a été créé avec succès";
      }
      else{
        return "Données non valides";
      }
  }
}
