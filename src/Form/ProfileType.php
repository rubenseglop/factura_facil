<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ExtraUserDataType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('name')
        ;
        $builder->add('avatar', FileType::class , array('data_class'=> null, "attr"=> array(), 'required' => false));
        $builder->add('extraUserData', ExtraUserDataType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
