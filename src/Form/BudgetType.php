<?php

namespace App\Form;

use App\Entity\Budget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('budgetNumber')
            ->add('startDate')
            ->add('endDate')
            ->add('description')
            ->add('amountIVA')
            ->add('amountWithoutIVA')
            ->add('totalAmount')
            ->add('status')
            ->add('contractClause')
            ->add('visits')
            ->add('budgetKey')
            ->add('accepted')
            ->add('company')
            ->add('client')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Budget::class,
        ]);
    }
}
