<?php

/*
 * This file is part of the JuliusEventBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Checker;

use Eo\EcommerceBundle\EcommerceEvents;
use Eo\EcommerceBundle\Event\InventoryCheckEvent;
use Eo\EcommerceBundle\Document\Product\ProductInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Eo\EcommerceBundle\Checker\InventoryChecker
 */
class InventoryChecker implements InventoryCheckerInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Class constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function check(ProductInterface $product)
    {
        // Dispatch InventoryCheckEvent
        $event = new InventoryCheckEvent($product);
        $this->container->get('event_dispatcher')->dispatch(EcommerceEvents::INVENTORY_CHECK, $event);

        // @TODO
        return false;
    }
}
