<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;

class MessageController extends AbstractController
{
    #[Route('/contact', name: 'app_message')]
    public function index(): Response
    {
        $contact = new Message();
        $form =$this->createFormBuilder($contact)
                ->add('nom')
                ->add('prenom')
                ->add('email')
                ->add('message')
                ->getForm();
        return $this->render('message/contact.html.twig', [
            'formContact' => $form->createView(),
        ]);
    }
}
