<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;
use App\Entity\Message;
use App\Service\GestionContact;
use Doctrine\ORM\EntityManagerInterface;

class MessageController extends AbstractController
{
    #[Route('/contact', name: 'app_message')]
    public function nouveauFormulaire(Request $request, EntityManagerInterface $em ): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $message = $form->getData();
            $service = new GestionContact($em);
            $service->creerMessageBDD($message);
            $this->addFlash('success', 'Message bien envoyé !');
            return $this->redirectToRoute('app_message');
        }
        return $this->render('message/contact.html.twig', [
            'formContact' => $form->createView(),
        ]);
    }
}
