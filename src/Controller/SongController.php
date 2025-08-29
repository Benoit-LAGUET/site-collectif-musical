<?php

namespace App\Controller;

use App\Entity\Song;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}