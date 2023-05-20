<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('imageFile', FileType::class, [
            'required' => false,
            'label' => 'News Image',
        ])
            ->add('title')
            ->add('content')
            ->add('createdAt', DateType::class, [
                'years' => range(date('Y')-70, date('Y')),
                'widget' => 'choice',
                'label' => 'createdAt',
                'attr' => [
                    'type' =>'date',
                    'min' => '1920',
                    'max' => date('Y')
                ]])    
                ->add('updatedAt', DateType::class, [
                    'years' => range(date('Y')-70, date('Y')),
                    'widget' => 'choice',
                    'label' => 'updatedAt',
                    'attr' => [
                        'type' =>'date',
                        'min' => '1920',
                        'max' => date('Y')
                    ]])    

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
