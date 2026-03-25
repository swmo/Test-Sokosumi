<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event/{id}', name: 'app_event_show')]
    public function show(Event $event, RegistrationRepository $registrationRepository): Response
    {
        $isRegistered = false;
        if ($this->getUser()) {
            $existing = $registrationRepository->findByUserAndEvent($this->getUser(), $event);
            $isRegistered = $existing !== null;
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'isRegistered' => $isRegistered,
        ]);
    }

    #[Route('/event/{id}/register', name: 'app_event_register', methods: ['POST'])]
    public function register(
        Event $event,
        EntityManagerInterface $em,
        RegistrationRepository $registrationRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($event->isFullyBooked()) {
            $this->addFlash('danger', 'Dieser Einsatz ist leider bereits ausgebucht.');
            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }

        $user = $this->getUser();
        $existing = $registrationRepository->findByUserAndEvent($user, $event);

        if ($existing) {
            $this->addFlash('warning', 'Sie sind bereits fuer diesen Einsatz angemeldet.');
            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }

        $registration = new Registration();
        $registration->setUser($user);
        $registration->setEvent($event);

        $em->persist($registration);
        $em->flush();

        $this->addFlash('success', 'Sie wurden erfolgreich fuer den Einsatz angemeldet!');
        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
    }

    #[Route('/event/{id}/unregister', name: 'app_event_unregister', methods: ['POST'])]
    public function unregister(
        Event $event,
        EntityManagerInterface $em,
        RegistrationRepository $registrationRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $existing = $registrationRepository->findByUserAndEvent($user, $event);

        if ($existing) {
            $em->remove($existing);
            $em->flush();
            $this->addFlash('success', 'Ihre Anmeldung wurde erfolgreich storniert.');
        }

        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
    }
}
