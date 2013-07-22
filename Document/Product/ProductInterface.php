<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Document\Product;

use Eo\EcommerceBundle\Document\Price\PriceInterface;

/**
 * Eo\EcommerceBundle\Document\Product\ProductInterface
 */
interface ProductInterface
{
    /**
     * Set sku
     *
     * @param  string $sku
     * @return self
     */
    public function setSku($sku);

    /**
     * Get sku
     *
     * @return string $sku
     */
    public function getSku();

    /**
     * Set name
     *
     * @param  string $name
     * @return self
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName();

    /**
     * Set type
     *
     * @param string $type
     * @return self
     */
    public function setType($type);

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType();

    /**
     * Set price
     *
     * @param PriceInterface $price
     * @return self
     */
    public function setPrice(PriceInterface $price = null);

    /**
     * Get price
     *
     * @return PriceInterface $price
     */
    public function getPrice();
}