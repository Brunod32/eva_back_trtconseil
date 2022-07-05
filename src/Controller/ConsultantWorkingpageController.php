<?php

namespace App\Controller;

use App\Entity\Candidate;
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

    #[Route('/consultant/workingpagevalidate', name: 'app_consultant_workingpage_validate')]
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

        return $this->redirectToRoute('app_consultant_workingpage_validate', [
            'id' => $id
        ]);
    }

}
