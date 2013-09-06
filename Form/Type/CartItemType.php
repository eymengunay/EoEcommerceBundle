<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Form\Type;

use Eo\EcommerceBundle\Document\Product\ProductInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CartItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sku', 'text', array(
                'read_only'  => true
            ))
            ->add('name', 'text', array(
                'read_only'  => true
            ))
            ->add('price', 'text', array(
                'read_only'  => true
            ))
            ->add('quantity', 'integer', array(
                'required'    => true,
                'data'        => 0,
                'attr'        => array(
                    'placeholder' => 0,
                    'min'         => 0,
                    // Yes it sucks that this variable is hand-coded. This will
                    // be dynamic As soon as Inventory support is added.
                    'max'         => 5,
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'eo_ecommerce_cart_item';
    }
}
