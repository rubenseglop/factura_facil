<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        /* Para poder modificar solo un dato hay que poner el segundo argumento que sea null y además
        un required => false para que no sea obligatorio completar dicho campo */ 
            ->add('name',TextType::class, ['required' => false,])
            ->add('fiscalAdress',TextType::class, ['required' => false])
            ->add('NIF',null, ['required' => false])
            ->add('email', EmailType::class, ['required' => false])
            ->add('phone',TextType::class, ['required' => false])
            ->add('web',null, ['required' => false])
            ->add('bossName',TextType::class, ['required' => false])
            ->add('bossPhone',TextType::class, ['required' => false])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
