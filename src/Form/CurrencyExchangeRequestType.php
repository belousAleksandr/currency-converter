<?php

namespace App\Form;

use App\Util\CurrencyExchangeRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyExchangeRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currencyFrom')
            ->add('currencyTo')
            ->add('amount')
            ->add('source')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CurrencyExchangeRequest::class,
            'csrf_protection' => false
        ]);
    }
}
