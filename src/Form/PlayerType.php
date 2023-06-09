<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Player Image',
            ])

            ->add('firstName')
            ->add('lastName')
              
              
            ->add('nationality')
            ->add('birthDate', DateType::class, [
                'years' => range(date('Y')-70, date('Y')),
                'widget' => 'choice',
                'label' => 'Birth Date',
                'attr' => [
                    'type' =>'date',
                    'min' => '1920',
                    'max' => date('Y')
                ]])    
            ->add('gender')
            ->add('height')
            ->add('weight')
            ->add('handedness')
            ->add('ranking')
            ->add('titles')
            ->add('bio')
            ->add('email')
            ->add('password',RepeatedType::class, [
                'type'=>PasswordType::class,
                'first_options'=>['label'=>'Password'],
                'second_options'=>['label'=>'Confirm Password']
            ])
            ->add('Add', SubmitType::class)
           
       
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
