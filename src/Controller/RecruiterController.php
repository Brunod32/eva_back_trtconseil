<?php

namespace App\Controller;

use App\Entity\Recruiter;
use App\Repository\RecruiterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recruiter')]
class RecruiterController extends AbstractController
{
    #[Route('/recruiter', name: 'app_recruiter')]
    public function index(): Response
    {
        return $this->render('recruiter/index.html.twig');
    }

    #[Route('/{id}/edit', name: 'app_create_consultant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recruiter $recruiter, RecruiterRepository $recruiterRepository): Response
    {
        $form = $this->createForm(ConsultantType::class, $recruiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recruiterRepository->add($recruiter, true);

            return $this->redirectToRoute('app_create_consultant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultant/edit.html.twig', [
            'consultant' => $recruiter,
            'form' => $form,
        ]);
    }
}
