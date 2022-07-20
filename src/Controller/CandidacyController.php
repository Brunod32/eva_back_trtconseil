<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\JobOffer;
use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class CandidacyController extends AbstractController
{
    #[Route('/candidacy/new/{idCandidate}/{idJobOffer}', name: 'app_candidacy', methods: ['GET', 'POST'])]
    public function newCandidacy(int $idCandidate, int $idJobOffer, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        // Récuperer le candidate
        $emCandidate = $doctrine->getRepository(Candidate::class)->find($idCandidate);;
        // $candidate = $em->find($idCandidate);
        // $idCandidate = $candidate->getId();

        // Récuperer l'annonce
        $emjobOffer = $doctrine->getRepository(JobOffer::class)->find($idJobOffer);
        // $jobOffer = $em->find($idJobOffer);
        // $idJobOffer = $jobOffer->getId();

        // On set les values dans table candidacy
        $candidacy = new Candidacy();
        // $candidacy->setCandidate($idCandidate);
        $candidacy->setCandidate($emCandidate);
        // $candidacy->setJobOffer($idJobOffer);
        $candidacy->setJobOffer($emjobOffer);
        $entityManager->persist($candidacy);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Vous avez postulé à une annonce. Un consultant doit valider votre demande.'
        );
        
        // return $this->render('candidacy/index.html.twig', [
        //     'idCandidate' => $idCandidate,
        //     'idJobOffer' => $idJobOffer
        // ]);

        return $this->redirectToRoute('app_job_offer_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
