<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
                'years' => range(date('Y')-100, date('Y')),
                'widget' => 'choice',
                'label' => 'Birth Date',
                'attr' => [
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
