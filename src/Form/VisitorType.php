<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;

class VisitorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email')
        ->add('name')
        
        ->add('gender', ChoiceType::class, [
            'choices' => [
                'Male' => 'male',
                'Female' => 'female',
            ],
            'placeholder' => 'Choose your gender',
        ])
        ->add('phonenumber')
        ->add('roles', ChoiceType::class, [
            'label' => 'Role',
            'multiple' => true,
            'choices' => [
                'Visitor' => 'ROLE_VISITOR',
                'Player' => 'ROLE_PLAYER',
                'Referee' => 'ROLE_REFEREE',
                'Admin' => 'ROLE_ADMIN',
                
            ],
        ])
        ->add('imageFile', FileType::class, [
            'required' => false,
            'label' => 'Player Image',
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
