<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class MailController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function index(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('bruno.dahlem2@gmail.com')
            ->to('bruno.dahlem@sfr.fr')
            ->subject('Test mail 25/07/22 à 09:51')
            ->text('mail 25/07/22 à 09:51')
            ->html('<p>mail 25/07/22 à 09:51</p>')
        ;

        $mailer->send($email);
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }
}
