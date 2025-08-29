<?php

namespace App\Controller;

use App\Entity\Song;
use App\Form\SongType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SongController extends AbstractController
{
    #[Route('/songs', name: 'public_songs', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $songs = $em->getRepository(Song::class)->findAll();

        return $this->render('song/index.html.twig', [
            'songs' => $songs,
        ]);
    }

    #[Route('/song/{id}', name: 'song_show', methods: ['GET'])]
    public function show(Song $song): Response
    {
        return $this->render('song/show.html.twig', [
            'song' => $song,
        ]);
    }

    #[Route('/song/new', name: 'song_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $song = new Song();
        $form = $this->createForm(SongType::class, $song);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($song);
            $em->flush();

            return $this->redirectToRoute('song_show', ['id' => $song->getId()]);
        }

        return $this->render('song/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}