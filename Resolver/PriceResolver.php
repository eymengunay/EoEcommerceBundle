<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Resolver;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Eo\EcommerceBundle\Resolver\PriceResolver
 */
class PriceResolver implements PriceResolverInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Class constructor
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container  = $container;
    }

    /**
     * Resolve price of given product
     *
     * @return PriceInterface
     */
    public function resolve($product)
    {
        $price = null;
        $resolvedPrices = array();
        // Check pricing conditions of given product
        $pricingConditions = $product->getPricingConditions();
        foreach ($pricingConditions as $pricingCondition) {
            $name  = $pricingCondition->getName();
            $condition = $this->getCondition($name);
            if ($condition && $condition->check()) {
                $resolved[] = $pricingCondition->getPrice();
            }
        }

        // If we have multiple prices matching to conditions
        // return lowest price. @TODO: make the 'lowest' configurable.
        foreach ($resolvedPrices as $resolvedPrice) {
            if (!isset($price)) {
                $price = $resolvedPrice;
                continue;
            }
            if ($price->getPrice() > $resolvedPrice->getPrice()) {
                $price = $resolvedPrice;
            }
        }

        // If we still don't have a price resolved then return the
        // highest price. @TODO: make the 'highest' configurable.
        if (!isset($price)) {
            $prices = $product->getPrices();
            if ($prices && !empty($prices)) {
                //$price = current($prices);
            }
        }

        return $price;
    }
}
