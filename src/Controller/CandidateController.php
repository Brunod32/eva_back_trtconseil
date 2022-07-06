<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Form\CandidateType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;


#[Route('/candidate')]
class CandidateController extends AbstractController
{
    #[Route('/candidate', name: 'app_candidate')]
    public function index(): Response
    {
        return $this->render('candidate/index.html.twig');
    }

    #[Route('/{id}/edit', name: 'app_candidate_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, Candidate $candidate, CandidateRepository $candidateRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Récupération du formulaire
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidate = $form->getData();
            $entityManager->persist($candidate);
            $entityManager->flush();

            /** @var UploadedFile $cv */
            $cvFile = $form->get('cv')->getData();
            
            // this condition is needed because the 'cv' field is not required
            // so the file must be processed only when a file is uploaded
            if ($cvFile) {
                $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
                  // this is needed to safely include the file name as part of the URL
                  $safeFilename = $slugger->slug($originalFilename);
                  $newFilename = $safeFilename.'-'.uniqid().'.'.$cvFile->guessExtension();
                
                // Move the file to the directory where cv are stored
                try {
                    $cvFile->move(
                        $this->getParameter('cv_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', $e->getMessage());
                }
 
                // updates the 'cvname' property to store the pdf file name
                $candidate->setCv($newFilename);
                $entityManager->persist($candidate);
                $entityManager->flush();
            }
            
            // $candidateRepository->add($candidate, true);

            return $this->redirectToRoute('app_candidate', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidate/edit.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidate_delete', methods: ['POST'])]
    public function delete(Request $request, Candidate $candidate, CandidateRepository $candidateRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidate->getId(), $request->request->get('_token'))) {
            $filename = $candidate->getCv();
            $candidateRepository->remove($candidate, true);

            // Supprimer la photo du dossier upload du serveur
            $fs = new Filesystem();
            $fs->remove($this->getParameter('cv_directory').'/'.$filename);
        }

        return $this->redirectToRoute('app_candidate', [], Response::HTTP_SEE_OTHER);
    }
}
