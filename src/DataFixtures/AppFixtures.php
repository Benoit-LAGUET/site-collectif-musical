<?php

namespace App\DataFixtures;

use App\Entity\Member;
use App\Entity\Instrument;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Instruments
        $guitare = (new Instrument())->setName('Guitare');
        $basse   = (new Instrument())->setName('Basse');
        $batterie = (new Instrument())->setName('Batterie');
        $chant   = (new Instrument())->setName('Chant');
        $manager->persist($guitare);
        $manager->persist($basse);
        $manager->persist($batterie);
        $manager->persist($chant);

        // Membres
        $alex = (new Member())
            ->setFirstName('Alex')
            ->setLastName('Durand')
            ->setRole('Chanteur');
        $alex->getInstruments()->add($chant);
        $manager->persist($alex);

        $marie = (new Member())
            ->setFirstName('Marie')
            ->setLastName('Lefèvre')
            ->setRole('Guitariste');
        $marie->getInstruments()->add($guitare);
        $manager->persist($marie);

        $paul = (new Member())
            ->setFirstName('Paul')
            ->setLastName('Martin')
            ->setRole('Batteur');
        $paul->getInstruments()->add($batterie);
        $manager->persist($paul);

        // Un événement
        $event = (new Event())
            ->setTitle('Concert d’été')
            ->setDate(new \DateTime('+1 month'))
            ->setLieu('Cité des Arts, Paris')
            ->setDescription('Premier concert officiel du groupe 🎶');
        $manager->persist($event);

        $manager->flush();
    }
}
