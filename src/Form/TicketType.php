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


class TicketType extends AbstractType //cree ou modif ticket
{
    private Security $security; //service de secu pour les roles

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void //les champs du form
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

        //ajout conditionnel des champs suppl
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

        public function configureOptions(OptionsResolver $resolver): void //option par defaut
        {
            $resolver->setDefaults([
                'data_class' => Ticket::class,
            ]);
        }
    }
