<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Form\JobOfferType;
use App\Entity\Candidate;
use App\Repository\JobOfferRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class JobOfferController extends AbstractController
{
    #[Route('/job/offer/', name: 'app_job_offer_index', methods: ['GET'])]
    public function index(JobOfferRepository $jobOfferRepository): Response
    {   
        return $this->render('job_offer/index.html.twig', [
            'job_offers' => $jobOfferRepository->findAll(),
        ]);
    }

    #[Route('/recruiter/job/offer/new', name: 'app_job_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JobOfferRepository $jobOfferRepository): Response
    {
        $jobOffer = new JobOffer();
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

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

    #[Route('/job/offer/{id}', name: 'app_job_offer_show', methods: ['GET'])]
    public function show(JobOffer $jobOffer): Response
    {
        return $this->render('job_offer/show.html.twig', [
            'job_offer' => $jobOffer,
        ]);
    }

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

    #[Route('/job/offer/{id}', name: 'app_job_offer_delete', methods: ['POST'])]
    public function delete(Request $request, JobOffer $jobOffer, JobOfferRepository $jobOfferRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobOffer->getId(), $request->request->get('_token'))) {
            $jobOfferRepository->remove($jobOffer, true);
        }

        return $this->redirectToRoute('app_job_offer_index', [], Response::HTTP_SEE_OTHER);
    }

    
    #[Route('/job/offer/candidate-apply/{idCandidate}/{idOffer}', name: 'app_job_offer_apply')]
    public function postule(): Response
    {

        // Code pour sauvegarder en BDD les candidature des candidates / offres 

        
        return $this->render('job_offer/candidateApply.html.twig');
    }

//     #[Route('/job/offer/candidate-apply/{id}/{idCandidate}', name: 'app_job_offer_apply', methods: ['GET'])]
// //    #[ParamConverter(
// //        'id',
// //        class: JobOffer::class,
// //        options: ['id' => 'id'],
// //    )]
//     public function candidateApply(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, JobOffer $joboffer, Candidate $candidate, JobOfferRepository $jobOfferRepository): Response
//     {
//         // $emCandidate = $doctrine->getRepository(Candidate::class);
//         // $candidate = $emCandidate->find($id);
//         // $idCandidate = $candidate->getId();
//         // $entityManager->flush();

//         // $emJobOffer = $doctrine->getRepository(JobOffer::class);
//         // $joboffer = $emJobOffer->find($id);
//         // $joboffer->addCandidate($candidate);
//         // $idJobOffer = $joboffer->getId();
//         // $entityManager->flush();

//         return $this->render('job_offer/candidateApply.html.twig', [
//             // 'id' => $idJobOffer,
//             // 'idCandidate' => $idCandidate,
//         ]);
//     }

}
