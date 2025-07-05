<?php

namespace App\Controller;

use App\Entity\Sobject;
use App\Form\Sobject1Form;
use App\Repository\SobjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sobject')]
final class SobjectController extends AbstractController
{
    #[Route(name: 'app_sobject_index', methods: ['GET'])]
    public function index(SobjectRepository $sobjectRepository): Response
    {
        return $this->render('sobject/index.html.twig', [
            'sobjects' => $sobjectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sobject_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sobject = new Sobject();
        $form = $this->createForm(Sobject1Form::class, $sobject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sobject);
            $entityManager->flush();

            return $this->redirectToRoute('app_sobject_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sobject/new.html.twig', [
            'sobject' => $sobject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sobject_show', methods: ['GET'])]
    public function show(Sobject $sobject): Response
    {
        return $this->render('sobject/show.html.twig', [
            'sobject' => $sobject,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sobject_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sobject $sobject, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Sobject1Form::class, $sobject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sobject_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sobject/edit.html.twig', [
            'sobject' => $sobject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sobject_delete', methods: ['POST'])]
    public function delete(Request $request, Sobject $sobject, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sobject->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sobject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sobject_index', [], Response::HTTP_SEE_OTHER);
    }
}
