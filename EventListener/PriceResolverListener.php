<?php

namespace Eo\EcommerceBundle\EventListener;

use Eo\EcommerceBundle\Document\Product\CustomProductInterface;
use Eo\EcommerceBundle\Document\Variant\VariantInterface;
use Eo\EcommerceBundle\Resolver\PriceResolver;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

class PriceResolverListener
{
    /**
     * @var PriceResolver
     */
    protected $priceResolver;

    /**
     * Class constructor
     *
     * @param PriceResolver $priceResolver
     */
    public function __construct(PriceResolver $priceResolver)
    {
        $this->priceResolver = $priceResolver;
    }

    /**
     * On document post load
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getDocument();

        if ($object instanceof VariantInterface) {
            // Resolve price
            $price = $this->priceResolver->resolve($object);
        } elseif ($object instanceof CustomProductInterface) {
            // Set min/max
            list($min, $max) = $this->priceResolver->resolveMinMax($object);
        }
    }
}