<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Recruiter;
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
    public function showCandidateToValidate(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getRepository(Candidate::class);
        $candidatesLists = $em->findAll();
        foreach($candidatesLists as $candidatesList)
        {
        $id = $candidatesList->getId();
        $lastname = $candidatesList->getlastname();
        $firstname = $candidatesList->getfirstname();
        $email = $candidatesList->getemail();
        $job = $candidatesList->getjob();
        $status = $candidatesList->getisValid();
        }

        return $this->render('consultant_workingpage/validate.html.twig', [
            'Id' => $id,
            'Nom' => $lastname,
            'Prénom' => $firstname,
            'Email' => $email,
            'Job' => $job,
            'Status' => $status
        ]);
    }


    #[Route('/consultant/workingpagevalidation/{id}', name: 'app_consultant_workingpage_validation')]
    public function validate(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, Candidate $candidate): Response
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
    public function showRecruiterToValidate(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getRepository(Recruiter::class);
        $recruitersLists = $em->findAll();
        foreach($recruitersLists as $recruitersList)
        {
        $id = $recruitersList->getId();
        $lastname = $recruitersList->getlastname();
        $firstname = $recruitersList->getfirstname();
        $email = $recruitersList->getemail();
        $status = $recruitersList->getIsValid();
        }

        return $this->render('consultant_workingpage/validate-recruiter.html.twig', [
            'Id' => $id,
            'Nom' => $lastname,
            'Prénom' => $firstname,
            'Email' => $email,
            'Status' => $status
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
}
