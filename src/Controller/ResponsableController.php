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
    public function index(ResponsableRepository $responsableRepository): Response //affiche liste responsables
    {
        $responsables = $responsableRepository->findAll(); //recup tous les resp depuis la BDD

        return $this->render('responsable/index.html.twig', [
            'responsables' => $responsables, //retourne la vue avec liste responsables
        ]);
    }

    public function create(Request $request, EntityManagerInterface $entityManager): Response //fct création nouveau resp
    {
        $responsable = new Responsable(); //nouvelle instance de resp
        $form = $this->createForm(ResponsableType::class, $responsable); //crée un form

        $form->handleRequest($request); //gere les data avec la requete
        if ($form->isSubmitted() && $form->isValid()) { //si form soumis et valide
            $entityManager->persist($responsable);
            $entityManager->flush(); //dans la BDD

            return $this->redirectToRoute('responsable_index'); //redirige apres crea
        }

        return $this->render('responsable/create.html.twig', [
            'form' => $form->createView(), //retourne vue avec form crea
        ]);
    }

    /**
     * @Route("/admin/responsable/{id}/edit", name="responsable_edit", methods={"GET", "POST"})
     */
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response //modif un responsable
    {
        //recup le responsable à modif
        $responsable = $entityManager->getRepository(Responsable::class)->find($id);

        if (!$responsable) { //si le resp n'existe pas
            throw $this->createNotFoundException('Le responsable demandé n\'existe pas.');
        }

        $form = $this->createForm(ResponsableType::class, $responsable);//créer le form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { //verif
            $entityManager->flush(); //save dans la BDD
            
            $this->addFlash('success', 'Responsable mis à jour avec succès.');
            return $this->redirectToRoute('responsable_index'); //redirection après update
        }
    
        return $this->render('responsable/edit.html.twig', [ //rendu du form
            'form' => $form->createView(),
            'responsable' => $responsable,
        ]);
    }

    /**
     * @Route("/admin/responsable/{id}/delete", name="responsable_delete", methods={"POST"})
     */
    public function delete(int $id, Request $request, EntityManagerInterface $entityManager): Response //suppr un resp
    {
        $responsable = $entityManager->getRepository(Responsable::class)->find($id); //recup resp

        if (!$responsable) { //si n'existe pas
            throw $this->createNotFoundException('Le responsable demandé n\'existe pas.');
        }

        //verif si token valide
        if ($this->isCsrfTokenValid('delete_responsable_' . $responsable->getId(), $request->request->get('_token'))) {
            $entityManager->remove($responsable); //suppr le resp
            $entityManager->flush();

            $this->addFlash('success', 'Le responsable a été supprimé avec succès.'); //message succes
        } else {
            $this->addFlash('error', 'Action non autorisée.'); //mess refus
        }

        return $this->redirectToRoute('responsable_index'); //redirige vers liste resp
    }

}
