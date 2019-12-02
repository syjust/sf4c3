<?php

namespace App\Controller;

use App\Form\RegisterType;
use App\Services\Registration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods="GET")
     */
    public function login(AuthenticationUtils $authUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/register", name="register", methods={"GET", "POST"})
     * @param Request      $request
     *
     * @param Registration $registration
     *
     * @return Response
     */
    public function register(Request $request, Registration $registration): Response
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registration->register($form->getData());
            $this->addFlash('notice', 'Welcome');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/register.html.twig', ['form' => $form->createView()]);
    }
}
