<?php

namespace App\Form;

use App\Entity\SocialNetworks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialNetworksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('name', ChoiceType::class, array(
              'mapped' => false,
              'choices' => array(
                 'Facebook' => 'facebook',
                 'Twitter' => 'valor'
              )))*/
            ->add('name')
            ->add('URL')
            //->add('company')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SocialNetworks::class,
        ]);
    }
}
