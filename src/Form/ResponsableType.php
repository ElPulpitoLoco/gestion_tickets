<?php

namespace App\Form;

use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableType extends AbstractType //permet de cree ou modif un resp
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [ //ajout champs type text pour nom
                'label' => 'Nom',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void //option par defaut
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}
