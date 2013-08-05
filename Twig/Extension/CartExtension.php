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

/**
 * Eo\EcommerceBundle\Twig\Extension\CartExtension
 */
class CartExtension extends \Twig_Extension
{
    /**
     * @var CartManagerInterface
     */
    protected $cm;

    /**
     * Class constructor
     *
     * @param CartManagerInterface $cm
     */
    public function __construct(CartManagerInterface $cm)
    {
        $this->cm = $cm;
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
            ))
        );
    }

    /**
     * Current user cart
     *
     * @return CartInterface
     */
    public function getCurrentCart(\Twig_Environment $env, $context, $scope = null, $options = array())
    {
        return $this->cm->getCurrentCart();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cart_extension';
    }
}
