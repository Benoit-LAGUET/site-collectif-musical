<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Song;
use App\Entity\Vote;
use App\Form\VoteType;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class VoteController extends AbstractController
{
    #[Route('/song/{id}/vote', name: 'song_vote', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function vote(Song $song, Request $request, EntityManagerInterface $em): Response
    {
        // Récupère ou crée le vote du membre courant pour ce morceau
        $user = $this->getUser();
        if (!method_exists($user, 'getId')) {
            throw $this->createAccessDeniedException('Utilisateur non valide.');
        }

        $vote = $em->getRepository(Vote::class)->findOneBy([
            'member' => $user,
            'song' => $song,
        ]) ?? (new Vote())->setMember($user)->setSong($song);

        $form = $this->createForm(VoteType::class, $vote, ['song' => $song]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($vote);
            $em->flush();

            return $this->redirectToRoute('song_show', ['id' => $song->getId()]);
        }

        return $this->render('vote/vote.html.twig', [
            'form' => $form->createView(),
            'song' => $song,
        ]);
    }
}
