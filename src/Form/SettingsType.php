<?php

namespace App\Form;

use App\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('keywords')
            ->add('firmname')
            ->add('address')
            ->add('fax')
            ->add('tel')
            ->add('email')
            ->add('facebook')
            ->add('twitter')
            ->add('instagram')
            ->add('linkedin')
            ->add('smtpserver')
            ->add('smtpemail')
            ->add('smtppasw', PasswordType::class, [
                'attr' => [
                    'type' => 'password',
                ]
            ])
            ->add('smtpport')
            ->add('aboutus')
            ->add('contact')
            ->add('referances')
            ->add('create_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Settings::class,
        ]);
    }
}
