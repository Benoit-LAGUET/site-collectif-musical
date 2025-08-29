<?php

namespace App\Controller;

use App\Repository\MemberRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[Route('/', name: 'site_index')]
    public function index(MemberRepository $memberRepo, EventRepository $eventRepo): Response
    {
        $members = $memberRepo->findAll();

        $events = $eventRepo->createQueryBuilder('e')
            ->where('e.date >= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('site/index.html.twig', [
            'members' => $members,
            'events' => $events,
        ]);
    }

    #[Route('/membre/{id}', name: 'site_member')]
    public function member(\App\Entity\Member $member): Response
    {
        return $this->render('site/member.html.twig', [
            'member' => $member,
        ]);
    }

    #[Route('/event/{id}', name: 'site_event')]
    public function event(\App\Entity\Event $event): Response
    {
        return $this->render('site/event.html.twig', [
            'event' => $event,
        ]);
    }

}
