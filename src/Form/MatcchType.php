<?php

namespace App\Form;

use App\Entity\Matcch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;





class MatcchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date', DateType::class, [
            'years' => range(date('Y')-100, date('Y')),
            'widget' => 'choice',
            'label' => 'Date',
            'attr' => [
                'min' => '1920',
                'max' => date('Y')
            ]])    
            ->add('tournament')
            ->add('player1')
            ->add('player2')
            ->add('winner')
            ->add('loser')
            ->add('resultat')
            ->add('etat')
            ->add('Add', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matcch::class,
        ]);
    }
}
