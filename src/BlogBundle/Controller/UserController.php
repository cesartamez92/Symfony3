<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\User;
use BlogBundle\Form\UserType;

class UserController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function loginAction(Request $request){
        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User;
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if ($form->isValid()) {
                $user = new User;
                $user->setName($form->get("name")->getData());
                $user->setEmail($form->get("email")->getData());
                $user->setPassword($form->get("password")->getData());
                $user->setSurname($form->get("surname")->getData());
                $user->setRole("ROLE_USER");
                $user->setImagen(null);

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $flush = $em->flush();

                if ($flush == null) {
                    $status = "El usuario se ha creado correctamente";
                } else {
                    $status = "No te has registrado correctamente";
                }

            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
        }

        return $this->render("BlogBundle:user:login.html.twig",array(
           "error"=> $error,
           "last_username" => $lastUsername,
           "form" => $form->createView()
        ));
    }
}
