<?php

namespace Eo\EcommerceBundle;

final class EcommerceEvents
{
    /**
     * The inventory.check event is thrown each time a product needs
     * stock information.
     *
     * The event listener receives an
     * Eo\EcommerceBundle\Event\InventoryCheckEvent instance.
     *
     * @var string
     */
    const INVENTORY_CHECK = 'inventory.check';
}