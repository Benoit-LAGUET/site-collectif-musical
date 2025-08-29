<?php

namespace App\Controller\Admin;

use App\Entity\Vote;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class VoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vote::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('member', 'Membre'),
            AssociationField::new('song', 'Morceau'),
            AssociationField::new('chosenInstruments', 'Instruments choisis')
                ->setFormTypeOptions(['by_reference' => false])
                ->setHelp('Choisissez au moins 2 instruments'),
        ];
    }
}