<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Statut;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\SecurityBundle\Security;


class TicketType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('description')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => 'Choisissez une catégorie',
            ]);

        // Ajout conditionnel des champs supplémentaires
        if ($this->security->isGranted('ROLE_USER')) {
            $builder
                ->add('dateOuverture', null, [
                    'widget' => 'single_text',
                ])
                ->add('dateCloture', null, [
                    'widget' => 'single_text',
                ])
                ->add('responsable')
                ->add('statut', EntityType::class, [
                    'class' => Statut::class,
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisir un statut',
                ]);
        }
    }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Ticket::class,
            ]);
        }
    }
