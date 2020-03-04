<?php

namespace App\Form;

use App\Entity\Bill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AddNewBillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descriptionBill', TextareaType::class)
            ->add('amountIVA')
            ->add('amountWithoutIVA')
            ->add('totalInvoiceAmount')
            ->add('client')
            ->add('billLines', CollectionType::class, [
                  'entry_type' => AddNewBillLineType::class,
                  'entry_options' => ['label' => false],
                  'allow_add' => true,
                  'allow_delete' => true,
            ]);
        $builder->add('dateBill', DateType::class, [
            'required' => true,
        ]);
        $builder->get('dateBill')->addModelTransformer(new CallbackTransformer(
            function ($value) {
                if(!$value) {
                    return new \DateTime();
                }
                return $value;
            },
            function ($value) {
                return $value;
            }
        ));
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bill::class,
        ]);
    }
}
