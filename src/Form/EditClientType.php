<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        /* Para poder modificar solo un dato hay que poner el segundo argumento que sea null y además
        un required => false para que no sea obligatorio completar dicho campo */ 
            ->add('name',null, ['required' => false])
            ->add('fiscalAdress',null, ['required' => false])
            ->add('NIF',null, ['required' => false])
            ->add('email',null, ['required' => false])
            ->add('phone',null, ['required' => false])
            ->add('web',null, ['required' => false])
            ->add('bossName',null, ['required' => false])
            ->add('bossPhone',null, ['required' => false])
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
