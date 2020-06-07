<?php

namespace App\Form;

use App\Entity\Food;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('image')
            ->add('price')
            ->add('keywords')
            ->add('description')
            ->add('images')
            ->add('status', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Show' => 1,
                    'Hiddent' => 0,
                ]
            ])
//            ->add('created_at')
//            ->add('updated_at')
            ->add('category', CategoryType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}
