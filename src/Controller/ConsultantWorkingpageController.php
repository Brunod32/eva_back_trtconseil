<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Recruiter;
use App\Entity\JobOffer;
use App\Entity\Candidacy;
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
    #[Route('/consultant/workingpage', name: 'app_consultant_workingpage')]
    public function index(): Response
    {
        return $this->render('consultant_workingpage/index.html.twig');
    }

    #[Route('/consultant/workingpagevalidate-candidate', name: 'app_consultant_workingpage_validate_candidate')]
    public function showCandidateToValidate(ManagerRegistry $doctrine, CandidateRepository $candidateRepository): Response
    {
        return $this->render('consultant_workingpage/validate.html.twig', [
            'candidates' => $candidateRepository->findAll(),
        ]);
    }


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

    #[Route('/consultant/workingpagevalidate-recruiter', name: 'app_consultant_workingpage_validate_recruiter')]
    public function showRecruiterToValidate(ManagerRegistry $doctrine, RecruiterRepository $recruiterRepository): Response
    {
        return $this->render('consultant_workingpage/validate-recruiter.html.twig', [
            'recruiters' => $recruiterRepository->findAll(),
        ]);
    }

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

    #[Route('/consultant/workingpagevalidate-joboffer', name: 'app_consultant_workingpage_validate_joboffer')]
    public function showJobOfferToValidate(ManagerRegistry $doctrine, JobOfferRepository $jobofferRepository): Response
    {
        return $this->render('consultant_workingpage/validate-joboffer.html.twig', [
            'joboffers' => $jobofferRepository->findAll(),
        ]);
    }

    #[Route('/consultant/workingpagevalidation-joboffer/{id}', name: 'app_consultant_workingpage_validation_joboffer')]
    public function validateJoboffer(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, JobOffer $joboffer): Response
    {
        $em = $doctrine->getRepository(JobOffer::class);
        $joboffer = $em->find($id);
        $id = $joboffer->getId();
        $joboffer->setIsValid(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_consultant_workingpage_validate_joboffer', [
            'Id' => $id
        ]);
    }

    #[Route('/consultant/workingpagevalidate-candidacy', name: 'app_consultant_workingpage_validate_candidacy')]
    public function showCandidacyToValidate(CandidacyRepository $candidacyRepository): Response
    {
        return $this->render('consultant_workingpage/validate-candidacy.html.twig', [
            'candidacies' => $candidacyRepository->findAll(),
        ]);
    }

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
