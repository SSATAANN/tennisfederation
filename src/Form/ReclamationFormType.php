<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
class ReclamationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('user', EmailType::class, [
            'label' => 'Adresse',
            'property_path' => 'User.email', // Set the property path to "user.email" to access the "email" attribute of the related User entity
            'required' => true,
        ])
            ->add('sujet')
            ->add('description')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
            
        ]);
    }
}
