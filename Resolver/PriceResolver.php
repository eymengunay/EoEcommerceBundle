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

use Eo\EcommerceBundle\Document\Product\CustomProductInterface;
use Eo\EcommerceBundle\Document\Variant\VariantInterface;
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
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $resolvables = array();

    /**
     * Class constructor
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config    = $this->container->getParameter('eo_ecommerce.config');
    }

    /**
     * Add resolvable
     *
     * @param  VariantInterface $product
     * @return self
     */
    public function addResolvable(VariantInterface $product)
    {
        $this->resolvables[$product->getId()] = $product;
        return $this;
    }

    /**
     * Resolve price of given product
     *
     * @param  VariantInterface $product
     * @return PriceInterface
     */
    public function resolve(VariantInterface $product)
    {
        $in = array();

        foreach ($this->resolvables as $resolvable) {
            $in[] = $resolvable->getId();
        }


        // Check conditions
        $cm = $this->container->get("eo_ecommerce.condition_manager");
        $price = $cm->check($product);

        // If no conditions found then return the
        // highest price. @TODO: make the 'highest' configurable.
        if (is_null($price)) {
            $max = 0;
            $prices = $product->getPrices();
            foreach ($prices as $p) {
                if ($p->getPrice() > $max) {
                    $max = $p->getPrice();
                    $price = $p;
                }
            }
        }

        if (!is_null($price)) {
            $product->setPrice($price);
        }
        return $price;
    }

    /**
     * Resolve min/max prices of given product
     *
     * @param  CustomProductInterface $product
     * @return array                  $minmax  An array of min & max prices
     */
    public function resolveMinMax(CustomProductInterface $product)
    {
        //return array(null, null);
        $min = null;
        $max = null;
        // Loop through product variants
        foreach ($product->getVariants() as $variant) {
            $price = $variant->getPrice();
            if ($price && (!$min or $price->getPrice() < $min->getPrice())) {
                $min = $price;
                $product->setMinPrice($price);
            }
            if ($price && (!$max or $price->getPrice() > $max->getPrice())) {
                $max = $price;
                $product->setMaxPrice($price);
            }
        }
        return array($min, $max);
    }
}
