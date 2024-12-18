<?php

namespace App\Form;

use App\Entity\Statut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom') //ajout champs pour nom
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void //option par defaut
    {
        $resolver->setDefaults([
            'data_class' => Statut::class,
        ]);
    }
}
