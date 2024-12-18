<?php
// src/Controller/TicketController.php
namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Statut; // Importer l'entité Statut
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'ticket_index')]
    public function index(TicketRepository $ticketRepository): Response
    {
        // Afficher la liste des tickets
        $tickets = $ticketRepository->findAll();
        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/ticket/new', name: 'ticket_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // Créer un nouveau ticket
        $ticket = new Ticket();

        // Valeurs par défaut pour les visiteurs
        if (!$this->isGranted('ROLE_USER')) {
            $ticket->setDateOuverture(new \DateTime()); // Date d'ouverture par défaut

            // Récupérer le statut par défaut "Nouveau"
            $defaultStatut = $em->getRepository(Statut::class)->findOneBy(['nom' => 'Nouveau']);
            if (!$defaultStatut) {
                throw new \Exception("Le statut par défaut 'Nouveau' n'existe pas !");
            }
            $ticket->setStatut($defaultStatut); // Définir le statut par défaut
            $ticket->setResponsable(null);     // Pas de responsable pour les visiteurs
        }

        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ticket);
            $em->flush();

            // Rediriger les visiteurs vers une page de confirmation ou d'accueil
            if (!$this->isGranted('ROLE_USER')) {
                $this->addFlash('success', 'Votre ticket a été soumis avec succès. Nous vous remercions.');
                return $this->redirectToRoute('home'); // Remplacez 'home' par le nom de votre route d'accueil
            }

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('ticket/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ticket/{id}', name: 'ticket_show')]
    public function show(Ticket $ticket): Response
    {
        // Afficher un ticket spécifique
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/ticket/{id}/edit', name: 'ticket_edit')]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $em): Response
    {
        // Modifier un ticket
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('ticket_show', ['id' => $ticket->getId()]);
        }

        return $this->render('ticket/edit.html.twig', [
            'form' => $form->createView(),
            'ticket' => $ticket,
        ]);
    }

    #[Route('/ticket/{id}/delete', name: 'ticket_delete')]
    public function delete(Ticket $ticket, EntityManagerInterface $em): Response
    {
        // Supprimer un ticket
        $em->remove($ticket);
        $em->flush();

        return $this->redirectToRoute('ticket_index');
    }
}
