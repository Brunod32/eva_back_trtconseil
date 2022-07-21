<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Recruiter;
use App\Entity\JobOffer;
use App\Entity\Candidacy;
use App\Entity\Consultant;
use App\Repository\CandidateRepository;
use App\Repository\RecruiterRepository;
use App\Repository\JobOfferRepository;
use App\Repository\CandidacyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/consultant')]
class ConsultantWorkingpageController extends AbstractController
{
    // homepage consultant
    #[Route('/consultant/workingpage', name: 'app_consultant_workingpage')]
    public function index(): Response
    {
        return $this->render('consultant_workingpage/index.html.twig');
    }

    // Candidates list to validate page
    #[Route('/consultant/workingpagevalidate-candidate', name: 'app_consultant_workingpage_validate_candidate')]
    public function showCandidateToValidate(CandidateRepository $candidateRepository): Response
    {
        return $this->render('consultant_workingpage/validate.html.twig', [
            'candidates' => $candidateRepository->findAll(),
        ]);
    }

    // Candidates validation page
    #[Route('/consultant/workingpagevalidation/{id}', name: 'app_consultant_workingpage_validation')]
    public function validate(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getRepository(Candidate::class);
        $candidate = $em->find($id);
        $id = $candidate->getId();
        $candidate->setIsValid(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_consultant_workingpage_validate_candidate', [
            'Id' => $id
        ]);
    }

    // Recruiters list to validate page
    #[Route('/consultant/workingpagevalidate-recruiter', name: 'app_consultant_workingpage_validate_recruiter')]
    public function showRecruiterToValidate(RecruiterRepository $recruiterRepository): Response
    {
        return $this->render('consultant_workingpage/validate-recruiter.html.twig', [
            'recruiters' => $recruiterRepository->findAll(),
        ]);
    }

    // Recruiters validation page
    #[Route('/consultant/workingpagevalidation-recruiter/{id}', name: 'app_consultant_workingpage_validation_recruiter')]
    public function validateRecruiter(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, Recruiter $recruiter): Response
    {
        $em = $doctrine->getRepository(Recruiter::class);
        $recruiter = $em->find($id);
        $id = $recruiter->getId();
        $recruiter->setIsValid(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_consultant_workingpage_validate_recruiter', [
            'Id' => $id
        ]);
    }

    // Joboffers list to validate page
    #[Route('/consultant/workingpagevalidate-joboffer', name: 'app_consultant_workingpage_validate_joboffer')]
    public function showJobOfferToValidate(JobOfferRepository $jobofferRepository): Response
    {
        return $this->render('consultant_workingpage/validate-joboffer.html.twig', [
            'joboffers' => $jobofferRepository->findAll(),
        ]);
    }

    // JobOffers validation page
    #[Route('/consultant/workingpagevalidation-joboffer/{id}/{idConsultant}', name: 'app_consultant_workingpage_validation_joboffer')]
    public function validateJoboffer(int $id, int $idConsultant, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, JobOffer $joboffer): Response
    {
        // Récupérer le consultant
        $emConsultant = $doctrine->getRepository(Consultant::class)->find($idConsultant);

        $em = $doctrine->getRepository(JobOffer::class);
        $joboffer = $em->find($id);
        $id = $joboffer->getId();
        $joboffer->setIsValid(true);
        $joboffer->setConsultant($emConsultant);
        $entityManager->persist($joboffer);
        $entityManager->flush();

        // return $this->redirectToRoute('app_consultant_workingpage_validate_joboffer', [
        //     'Id' => $id
        // ]);

        return $this->redirectToRoute('app_consultant_workingpage_validate_joboffer', [], Response::HTTP_SEE_OTHER);
    }

    // Candidacies list to validate page
    #[Route('/consultant/workingpagevalidate-candidacy', name: 'app_consultant_workingpage_validate_candidacy')]
    public function showCandidacyToValidate(CandidacyRepository $candidacyRepository): Response
    {
        return $this->render('consultant_workingpage/validate-candidacy.html.twig', [
            'candidacies' => $candidacyRepository->findAll(),
        ]);
    }

    // Candidacies validation page
    #[Route('/consultant/workingpagevalidation-candidacy/{id}', name:'app_consultant_workingpage_validation_candidacy')]
    public function validateCandidacy(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, Candidacy $candidacy): Response
    {
        $em = $doctrine->getRepository(Candidacy::class);
        $candidacy = $em->find($id);
        $id = $candidacy->getId();
        $candidacy->setIsValid(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_consultant_workingpage_validate_candidacy', [
            'Id' => $id,
        ]);
    }
}
