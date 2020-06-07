<?php

namespace App\Form;

use App\Entity\Odr;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OdrType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('amount')
            ->add('status', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Pending' => 'Pending',
                    'On Way Orders' => 'On Way Orders',
                    'Delivered Orders' => 'Delivered Orders',
                ]
            ])
//            ->add('ordered_at')
//            ->add('ordered_by')
            ->add('product', null, [
                'mapped' =>true,
                'attr' => [
                    'read-only' => true,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Odr::class,
        ]);
    }
}
