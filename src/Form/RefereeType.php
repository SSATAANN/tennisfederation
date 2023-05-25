<?php

namespace App\Form;

use App\Entity\Referee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
class RefereeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('nationality')
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Player Image',
            ])
            ->add('Add', SubmitType::class)
            ->add('email')
            ->add('password',RepeatedType::class, [
                'type'=>PasswordType::class,
                'first_options'=>['label'=>'Password'],
                'second_options'=>['label'=>'Confirm Password']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Referee::class,
        ]);
    }
}
