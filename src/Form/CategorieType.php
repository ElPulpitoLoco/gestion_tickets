<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom') //ajout d'un champs pour le nom de la cat
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void //les options par defaut
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
