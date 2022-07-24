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
            ->to('to@example.com')
            ->subject('This e-mail is for testing purpose')
            ->text('This is the text version')
            ->html('<p>This is the HTML version</p>')
        ;

        $mailer->send($email);
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }
}
