<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Form\CandidateType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CandidateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidate')]
class CandidateController extends AbstractController
{
    #[Route('/candidate', name: 'app_candidate')]
    public function index(): Response
    {
        return $this->render('candidate/index.html.twig');
    }

    #[Route('/{id}/edit', name: 'app_candidate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidate $candidate, CandidateRepository $candidateRepository): Response
    {
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->add($candidate, true);

            return $this->redirectToRoute('app_candidate', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidate/edit.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
        ]);
    }
}
