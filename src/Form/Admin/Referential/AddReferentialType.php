<?php


namespace App\Form\Admin\Referential;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddReferentialType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class,
                [
                    'label' => 'Nom du réferentiel',
                ]
            )
            ->add('description', TextareaType::class,
                [
                    'label' => 'Déscription',
                    'required' => false,
                ]
            )
            ->add('save', SubmitType::class,
                [
                    'label' => 'Enregistrer',
                ]
            );
    }
}