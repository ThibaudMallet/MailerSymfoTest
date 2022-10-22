<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/", name="app_mailer", methods={"GET", "POST"})
     * 
     * @param Request $request
     * @param MailerService $mailerService
     */
    public function index(Request $request, MailerService $mailerService): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            
            $mailerService->send(
                "Nouveau message",
                "thibaud.mallet171293@gmail.com",
                "thibaud.mallet171293@gmail.com",
                "mailTpl.html.twig",
                [
                    "name" => $data->getName(),
                    "message" => $data->getLastname(),
                ],
            );

            return $this->redirectToRoute('app_mailer');
        }

        return $this->renderForm("mailer.html.twig", [
            "form" => $form,
        ]);
    }
}
