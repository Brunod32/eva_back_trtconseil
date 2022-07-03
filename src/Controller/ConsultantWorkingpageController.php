<?php

namespace App\Controller;

use App\Entity\Candidate;
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
        $repository = $doctrine->getRepository(Candidate::class);
        $candidatesLists = $repository->findAll();
        foreach($candidatesLists as $candidatesList)
        {
        
        $lastname = $candidatesList->getlastname();
        $firstname = $candidatesList->getfirstname();
        $email = $candidatesList->getemail();
        $job = $candidatesList->getjob();
        $status = $candidatesList->getisValid();
        }

        return $this->render('consultant_workingpage/validate.html.twig', [
            'Nom' => $lastname,
            'Prénom' => $firstname,
            'Email' => $email,
            'Job' => $job,
            'Status' => $status
        ]);
    }


}
