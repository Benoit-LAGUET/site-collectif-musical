<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\Song;
use App\Entity\Vote;
use App\Validator\AtLeastTwoInstruments;
use App\Validator\ChosenInstrumentsBelongToSong;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Song|null $song */
        $song = $options['song'] ?? null;
        $builder
            ->add('instruments', EntityType::class, [
                'class' => Instrument::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'choices' => $song ? $song->getInstruments() : [],
                'constraints' => [
                    new AtLeastTwoInstruments(),
                    new ChosenInstrumentsBelongToSong(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vote::class,
            'song' => null,
        ]);
        $resolver->setAllowedTypes('song', ['null', Song::class]);
    }
}
