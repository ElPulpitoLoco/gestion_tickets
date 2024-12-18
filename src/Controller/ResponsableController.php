<?php

namespace App\Controller;

use App\Entity\Responsable;
use App\Form\ResponsableType;
use App\Repository\ResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponsableController extends AbstractController
{
    public function index(ResponsableRepository $responsableRepository): Response
    {
        $responsables = $responsableRepository->findAll();

        return $this->render('responsable/index.html.twig', [
            'responsables' => $responsables,
        ]);
    }

    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $responsable = new Responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($responsable);
            $entityManager->flush();

            return $this->redirectToRoute('responsable_index');
        }

        return $this->render('responsable/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/responsable/{id}/edit", name="responsable_edit", methods={"GET", "POST"})
     */
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le responsable à modifier
        $responsable = $entityManager->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Le responsable demandé n\'existe pas.');
        }

        // Créer le formulaire
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Redirection après la mise à jour
            $this->addFlash('success', 'Responsable mis à jour avec succès.');
            return $this->redirectToRoute('responsable_index');
        }

        // Rendu du formulaire d'édition
        return $this->render('responsable/edit.html.twig', [
            'form' => $form->createView(),
            'responsable' => $responsable,
        ]);
    }

    /**
     * @Route("/admin/responsable/{id}/delete", name="responsable_delete", methods={"POST"})
     */
    public function delete(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le responsable
        $responsable = $entityManager->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Le responsable demandé n\'existe pas.');
        }

        // Vérifier le token CSRF
        if ($this->isCsrfTokenValid('delete_responsable_' . $responsable->getId(), $request->request->get('_token'))) {
            $entityManager->remove($responsable);
            $entityManager->flush();

            $this->addFlash('success', 'Le responsable a été supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Action non autorisée.');
        }

        return $this->redirectToRoute('responsable_index');
    }

}
