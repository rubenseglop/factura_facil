<?php

namespace App\Form;

use App\Entity\Bill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddNewBillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberBill')
            ->add('dateBill')
            ->add('descriptionBill')
            ->add('totalBillIva')
            ->add('totalImportBill')
            //->add('status')
            //->add('company')
            ->add('client')
            ->add('billLines', CollectionType::class, ['entry_type' => AddNewBillLineType::class, 'entry_options' => ['label' => false]])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bill::class,
        ]);
    }
}
