<?php

namespace Eo\EcommerceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PriceConditionType extends AbstractType
{
	/**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('variants', 'document', array(
                'class'     => 'Eo\EcommerceBundle\Document\Variant\Variant',
                'multiple'  => true,
                'require'   => true
            ))
            ->add('conditions', 'document', array(
                'class'     => 'Eo\EcommerceBundle\Document\Condition\Condition',
                'multiple'  => true,
                'require'   => true
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eo_ecommerce_price_condition';
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function getDefaultOptions(array $options)
    {
        return array(
                'data_class' => null
        );
    }
}