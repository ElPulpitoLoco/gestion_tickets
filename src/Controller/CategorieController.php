<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorie')]
class CategorieController extends AbstractController
{
    #[Route(name: 'app_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response //affiche la liste des cat
    {
        return $this->render('categorie/index.html.twig', [ //récup les categories et les affiches à la vue
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response //nouvelle cat
    {
        $categorie = new Categorie(); //new instance class cat
        $form = $this->createForm(CategorieType::class, $categorie); //crea form
        $form->handleRequest($request); //requete http

        if ($form->isSubmitted() && $form->isValid()) { //si form soumis et valide
            $entityManager->persist($categorie); //prep pour insert dans BDD
            $entityManager->flush(); //exec requetes en BDD

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);//apres creation redirige vers liste cat
        }

        return $this->render('categorie/new.html.twig', [ //affiche form crea
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response //montre les details d'une cat
    {
        return $this->render('categorie/show.html.twig', [ //affiche details d'une cat spe
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response //modif une cat qui existe
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { //si form valide et soumis
            $entityManager->flush(); //met a jour la BDD
            
            //redirige vers la liste des cat apres modif
            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie/edit.html.twig', [ //affiche le form modif
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response //efface une cat qui existe
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categorie); //prep la suppression
            $entityManager->flush(); //exec la sup
        }
        //redirige vers la liste apres sup
        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
