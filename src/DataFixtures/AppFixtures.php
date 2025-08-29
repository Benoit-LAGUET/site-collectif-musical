<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Instrument;
use App\Entity\Member;
use App\Entity\Song;
use App\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        // Instruments
        $guitare   = (new Instrument())->setName('Guitare');
        $basse     = (new Instrument())->setName('Basse');
        $batterie  = (new Instrument())->setName('Batterie');
        $chant     = (new Instrument())->setName('Chant');
        $clavier   = (new Instrument())->setName('Clavier');
        $saxophone = (new Instrument())->setName('Saxophone');

        foreach ([$guitare, $basse, $batterie, $chant, $clavier, $saxophone] as $i) {
            $manager->persist($i);
        }

        // Membres (4) avec email unique et mot de passe "test"
        $alex = (new Member())
            ->setFirstName('Alex')
            ->setLastname('Durand')
            ->setRole('Chanteur')
            ->setEmail('alex@example.com');
        $alex->setPassword($this->hasher->hashPassword($alex, 'test'));
        $manager->persist($alex);

        $marie = (new Member())
            ->setFirstName('Marie')
            ->setLastname('Lefèvre')
            ->setRole('Guitariste')
            ->setEmail('marie@example.com');
        $marie->setPassword($this->hasher->hashPassword($marie, 'test'));
        $manager->persist($marie);

        $paul = (new Member())
            ->setFirstName('Paul')
            ->setLastname('Martin')
            ->setRole('Batteur')
            ->setEmail('paul@example.com');
        $paul->setPassword($this->hasher->hashPassword($paul, 'test'));
        $manager->persist($paul);

        $lea = (new Member())
            ->setFirstName('Léa')
            ->setLastname('Dupont')
            ->setRole('Claviériste')
            ->setEmail('lea@example.com');
        $lea->setPassword($this->hasher->hashPassword($lea, 'test'));
        $manager->persist($lea);

        // Songs
        $takeFive = (new Song())
            ->setTitle('Take Five')
            ->setArtist('The Dave Brubeck Quartet')
            ->setInSetlist(true)
            ->addInstrument($batterie)
            ->addInstrument($saxophone)
            ->addInstrument($clavier);
        $manager->persist($takeFive);

        $sevenNationArmy = (new Song())
            ->setTitle('Seven Nation Army')
            ->setArtist('The White Stripes')
            ->setInSetlist(false)
            ->addInstrument($guitare)
            ->addInstrument($basse)
            ->addInstrument($batterie)
            ->addInstrument($chant);
        $manager->persist($sevenNationArmy);

        $otherSong = (new Song())
            ->setTitle('Wonderwall')
            ->setArtist('Oasis')
            ->setInSetlist(false)
            ->addInstrument($guitare)
            ->addInstrument($chant);
        $manager->persist($otherSong);

        // Votes (respect des contraintes: >= 2 instruments et appartenance au morceau)
        $v1 = (new Vote())
            ->setMember($alex)
            ->setSong($sevenNationArmy)
            ->addInstrument($chant)
            ->addInstrument($batterie);
        $manager->persist($v1);

        $v2 = (new Vote())
            ->setMember($marie)
            ->setSong($sevenNationArmy)
            ->addInstrument($guitare)
            ->addInstrument($chant);
        $manager->persist($v2);

        $v3 = (new Vote())
            ->setMember($paul)
            ->setSong($takeFive)
            ->addInstrument($batterie)
            ->addInstrument($clavier);
        $manager->persist($v3);

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

