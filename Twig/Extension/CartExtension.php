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
            'eo_cart' => new \Twig_Function_Method($this, 'getCart', array(
                'is_safe' => array('html'),
                'needs_environment' => false,
                'needs_context' => false,
            )),
            'eo_cart_count' => new \Twig_Function_Method($this, 'getCartCount', array(
                'is_safe' => array('html'),
                'needs_environment' => false,
                'needs_context' => false,
            )),
            'eo_cart_form' => new \Twig_Function_Method($this, 'getCartForm', array(
                'is_safe' => array('html'),
                'needs_environment' => true,
                'needs_context' => true,
            ))
        );
    }

    /**
     * Get current user cart
     *
     * @return CartInterface
     */
    public function getCart()
    {
        return $this->cm->getOrCreateCart();
    }

    /**
     * Get current user cart count
     *
     * @return int
     */
    public function getCartCount()
    {
        return $this->getCart()->countItems();
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
                'price' => $product->getPrice()->getPrice(),
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
