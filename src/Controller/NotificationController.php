<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notification")
 */
class NotificationController extends AbstractController
{

    /**
     * @var \App\Repository\NotificationRepository
     */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @Route("/unread-count", name="notification_unread")
     */
    public function unreadCount()
    {
        return new JsonResponse([
            'count' => $this->notificationRepository->findUnseenByUser($this->getUser()),
        ]);
    }

    /**
     * @Route("/all", name="notification_all")
     */
    public function notifications()
    {
        return $this->render('notification/index.html.twig', [
            'notifications' => $this->notificationRepository->findBy([
                'seen' => false,
                'user' => $this->getUser(),
            ]),
        ]);
    }
}
