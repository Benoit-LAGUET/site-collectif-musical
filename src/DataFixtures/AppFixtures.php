<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Instrument;
use App\Entity\Member;
use App\Entity\Song;
use App\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Instruments
        $guitare  = (new Instrument())->setName('Guitare');
        $basse    = (new Instrument())->setName('Basse');
        $batterie = (new Instrument())->setName('Batterie');
        $chant    = (new Instrument())->setName('Chant');

        foreach ([$guitare, $basse, $batterie, $chant] as $i) {
            $manager->persist($i);
        }

        // Membres (avec plusieurs instruments possibles)
        $alex = (new Member())
            ->setFirstName('Alex')
            ->setLastName('Durand')
            ->setRole('Chanteur');
        $alex->addInstrument($chant)->addInstrument($guitare);
        $manager->persist($alex);

        $marie = (new Member())
            ->setFirstName('Marie')
            ->setLastName('Lefèvre')
            ->setRole('Guitariste');
        $marie->addInstrument($guitare)->addInstrument($chant)->addInstrument($basse);
        $manager->persist($marie);

        $paul = (new Member())
            ->setFirstName('Paul')
            ->setLastName('Martin')
            ->setRole('Batteur');
        $paul->addInstrument($batterie)->addInstrument($basse);
        $manager->persist($paul);

        // Morceaux (Song) avec instruments requis
        $song1 = (new Song())
            ->setTitle('Back in Black')
            ->setArtist('AC/DC')
            ->setYoutubeLink('https://www.youtube.com/watch?v=pAgnJDJN4VA')
            ->setInSetlist(true)
            ->addInstrument($guitare)
            ->addInstrument($basse)
            ->addInstrument($batterie)
            ->addInstrument($chant);
        $manager->persist($song1);

        $song2 = (new Song())
            ->setTitle('Smells Like Teen Spirit')
            ->setArtist('Nirvana')
            ->setYoutubeLink('https://www.youtube.com/watch?v=hTWKbfoikeg')
            ->setInSetlist(false)
            ->addInstrument($guitare)
            ->addInstrument($basse)
            ->addInstrument($batterie)
            ->addInstrument($chant);
        $manager->persist($song2);

        $song3 = (new Song())
            ->setTitle('Zombie')
            ->setArtist('The Cranberries')
            ->setYoutubeLink('https://www.youtube.com/watch?v=6Ejga4kJUts')
            ->setInSetlist(false)
            ->addInstrument($guitare)
            ->addInstrument($basse)
            ->addInstrument($batterie)
            ->addInstrument($chant);
        $manager->persist($song3);

        // Votes (au moins 2 instruments choisis)
        // Alex vote sur Back in Black (chant + guitare)
        $v1 = (new Vote())
            ->setMember($alex)
            ->setSong($song1)
            ->addChosenInstrument($chant)
            ->addChosenInstrument($guitare);
        $manager->persist($v1);

        // Marie vote sur Back in Black (guitare + basse)
        $v2 = (new Vote())
            ->setMember($marie)
            ->setSong($song1)
            ->addChosenInstrument($guitare)
            ->addChosenInstrument($basse);
        $manager->persist($v2);

        // Paul vote sur Back in Black (batterie + basse)
        $v3 = (new Vote())
            ->setMember($paul)
            ->setSong($song1)
            ->addChosenInstrument($batterie)
            ->addChosenInstrument($basse);
        $manager->persist($v3);

        // Votes sur un autre morceau
        $v4 = (new Vote())
            ->setMember($marie)
            ->setSong($song2)
            ->addChosenInstrument($guitare)
            ->addChosenInstrument($chant);
        $manager->persist($v4);

        // Un événement (existant)
        $event = (new Event())
            ->setTitle('Concert d’été')
            ->setDate(new \DateTime('+1 month'))
            ->setLieu('Cité des Arts, Paris')
            ->setDescription('Premier concert officiel du groupe 🎶');
        $manager->persist($event);

        $manager->flush();
    }
}

