<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Entity\recruiter;
use App\Form\JobOfferType;
use App\Repository\JobOfferRepository;
use App\Repository\CandidacyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class JobOfferController extends AbstractController
{
    // Homepage Joboffer
    #[Route('/job/offer/', name: 'app_job_offer_index', methods: ['GET'])]
    public function index(JobOfferRepository $jobOfferRepository, CandidacyRepository $candidacyRepository): Response
    {   
        return $this->render('job_offer/index.html.twig', [
            'job_offers' => $jobOfferRepository->findAll(),
            'candidacies' => $candidacyRepository->findAll(),
        ]);
    }

    // Create new joboffer page
    #[Route('/recruiter/job/offer/new/{idRecruiter}', name: 'app_job_offer_new', methods: ['GET', 'POST'])]
    public function new(int $idRecruiter, EntityManagerInterface $entityManager,ManagerRegistry $doctrine, Request $request, JobOfferRepository $jobOfferRepository): Response
    {
        // Récupérer le recruteur
        $emRecruiter = $doctrine->getRepository(Recruiter::class)->find($idRecruiter);

        $jobOffer = new JobOffer();
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        $jobOffer->setRecruiter($emRecruiter);
        $entityManager->flush();

        if ($form->isSubmitted() && $form->isValid()) {
            $jobOfferRepository->add($jobOffer, true);

            $this->addFlash(
                'success',
                'Votre annonce a bien été enregistée. Un consultant doit la valider avant sa publication.'
            );

            return $this->redirectToRoute('app_job_offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_offer/new.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form,
        ]);
    }

    // Details joboffer page
    #[Route('/job/offer/{id}', name: 'app_job_offer_show', methods: ['GET'])]
    public function show(JobOffer $jobOffer): Response
    {
        return $this->render('job_offer/show.html.twig', [
            'job_offer' => $jobOffer,
        ]);
    }

    // Update joboffer page
    #[Route('/{id}/edit', name: 'app_job_offer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobOffer $jobOffer, JobOfferRepository $jobOfferRepository): Response
    {
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobOfferRepository->add($jobOffer, true);

            return $this->redirectToRoute('app_job_offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_offer/edit.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form,
        ]);
    }

    // Remove joboffer page
    #[Route('/job/offer/{id}', name: 'app_job_offer_delete', methods: ['POST'])]
    public function delete(Request $request, JobOffer $jobOffer, JobOfferRepository $jobOfferRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobOffer->getId(), $request->request->get('_token'))) {
            $jobOfferRepository->remove($jobOffer, true);
        }

        return $this->redirectToRoute('app_job_offer_index', [], Response::HTTP_SEE_OTHER);
    }
}
