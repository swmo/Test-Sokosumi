<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('', name: 'admin_dashboard')]
    public function dashboard(EventRepository $eventRepository, UserRepository $userRepository): Response
    {
        $events = $eventRepository->findAllOrderedByDate();
        $totalUsers = count($userRepository->findAll());

        return $this->render('admin/dashboard.html.twig', [
            'events' => $events,
            'totalUsers' => $totalUsers,
        ]);
    }

    #[Route('/events', name: 'admin_events')]
    public function events(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAllOrderedByDate();

        return $this->render('admin/events.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/event/neu', name: 'admin_event_new')]
    public function newEvent(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setCreatedBy($this->getUser());
            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Einsatz wurde erfolgreich erstellt.');
            return $this->redirectToRoute('admin_events');
        }

        return $this->render('admin/event_form.html.twig', [
            'form' => $form,
            'title' => 'Neuen Einsatz erstellen',
        ]);
    }

    #[Route('/event/{id}/bearbeiten', name: 'admin_event_edit')]
    public function editEvent(Event $event, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Einsatz wurde erfolgreich aktualisiert.');
            return $this->redirectToRoute('admin_events');
        }

        return $this->render('admin/event_form.html.twig', [
            'form' => $form,
            'title' => 'Einsatz bearbeiten',
            'event' => $event,
        ]);
    }

    #[Route('/event/{id}/loeschen', name: 'admin_event_delete', methods: ['POST'])]
    public function deleteEvent(Event $event, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $em->remove($event);
            $em->flush();
            $this->addFlash('success', 'Einsatz wurde erfolgreich geloescht.');
        }

        return $this->redirectToRoute('admin_events');
    }

    #[Route('/event/{id}/anmeldungen', name: 'admin_event_registrations')]
    public function eventRegistrations(Event $event): Response
    {
        return $this->render('admin/event_registrations.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/benutzer', name: 'admin_users')]
    public function users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }
}
