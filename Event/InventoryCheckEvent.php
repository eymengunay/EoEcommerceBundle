<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Event;

use Eo\EcommerceBundle\Document\Product\ProductInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Eo\EcommerceBundle\Event\InventoryCheckEvent
 */
class InventoryCheckEvent extends Event
{
    /**
     * @var ProductInterface
     */
    protected $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }
}
