<?php

namespace App\Form;

use App\Entity\Address;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Quel nom souhaitez vous donner à votre adresse',
                'attr'=>[
                    'placeholder'=>'Nommez votre adresse'
                ]
            ])
            ->add('firstName',TextType::class,[
                'label'=>'Prénom',
                'attr'=>[
                    'placeholder'=>'Prénom'
                ]
            ])
            ->add('lastName',TextType::class,[
                'label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'Nom'
                ]
            ])
            ->add('company',TextType::class,[
                'label'=>'Société',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Société'
                ]
            ])
            ->add('address',TextType::class,[
                'label'=>'Adresse',
                'attr'=>[
                    'placeholder'=>'Adresse'
                ]
            ])
            ->add('postal',TextType::class,[
                'label'=>'Code postal',
                'attr'=>[
                    'placeholder'=>'Code postal'
                ]
            ])
            ->add('city',TextType::class,[
                'label'=>'Ville',
                'attr'=>[
                    'placeholder'=>'Ville'
                ]
            ])
            ->add('country',CountryType::class,[
                'label'=>'Pays',
                'attr'=>[
                    'placeholder'=>'Pays'
                ]
            ])
            ->add('phone',TelType::class,[
                'label'=>'Téléphone',
                'attr'=>[
                    'placeholder'=>'Téléphone'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Valider',
                'attr'=>[
                    'class'=>'btn btn-success col-12'
                ]
            ])
          // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
