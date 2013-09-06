<?php

/*
 * This file is part of the JuliusEventBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Twig\Extension;

use Eo\EcommerceBundle\Manager\CartManagerInterface;
use Eo\EcommerceBundle\Document\Cart\CartInterface;
use Eo\EcommerceBundle\Document\Product\ProductInterface;
use Eo\EcommerceBundle\Document\Product\CustomProductInterface;
use Eo\EcommerceBundle\Form\Type\ProductType;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Eo\EcommerceBundle\Twig\Extension\CartExtension
 */
class CartExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var CartManagerInterface
     */
    protected $cm;

    /**
     * Class constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->cm = $container->get('eo_ecommerce.cart_manager');
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'current_cart' => new \Twig_Function_Method($this, 'getCurrentCart', array(
                'is_safe' => array('html'),
                'needs_environment' => true,
                'needs_context' => true,
            )),
            'cart_form' => new \Twig_Function_Method($this, 'getCartForm', array(
                'is_safe' => array('html'),
                'needs_environment' => true,
                'needs_context' => true,
            ))
        );
    }

    /**
     * Current user cart
     *
     * @return CartInterface
     */
    public function getCurrentCart(\Twig_Environment $env, $context)
    {
        return $this->cm->getCurrentCart();
    }

    /**
     * Get cart form
     *
     * @return CartInterface
     */
    public function getCartForm(\Twig_Environment $env, $context, ProductInterface $product)
    {
        $form = $this->container->get('form.factory')->create(new ProductType(), null);

        $products = array();
        if ($product instanceof CustomProductInterface && $product->getVariants()) {
            $products = $product->getVariants();
        } else {
            $products = array($product);
        }

        $data = array();
        foreach ($products as $product) {
            $data[] = array(
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            );
        }

        $form->setData(array(
            'products' => $data
        ));

        return $form->createView();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cart_extension';
    }
}
