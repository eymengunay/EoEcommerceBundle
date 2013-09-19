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

use Eo\EcommerceBundle\Checker\InventoryCheckerInterface;
use Eo\EcommerceBundle\Document\Product\ProductInterface;

/**
 * Eo\EcommerceBundle\Twig\Extension\InventoryExtension
 */
class InventoryExtension extends \Twig_Extension
{
    /**
     * @var InventoryCheckerInterface
     */
    protected $ic;

    /**
     * Class constructor
     *
     * @param InventoryCheckerInterface $ic
     */
    public function __construct(InventoryCheckerInterface $ic)
    {
        $this->ic = $ic;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'eo_inventory_is_available' => new \Twig_Function_Method($this, 'getIsAvailable', array(
                'is_safe' => array('html'),
                'needs_environment' => false,
                'needs_context' => false,
            ))
        );
    }

    /**
     * Get is available
     *
     * @return bool
     */
    public function getIsAvailable(ProductInterface $product)
    {
        return $this->ic->check($product);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eo_inventory_extension';
    }
}
