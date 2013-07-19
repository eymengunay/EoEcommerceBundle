<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Document\Variant;

use Eo\EcommerceBundle\Document\Product\ProductInterface;

/**
 * Eo\EcommerceBundle\Document\Variant\VariantInterface
 */
interface VariantInterface extends ProductInterface
{
    /**
     * Set product
     *
     * @param  ProductInterface $product
     * @return self
     */
    public function setProduct(ProductInterface $product);

    /**
     * Get product
     *
     * @return ProductInterface $product
     */
    public function getProduct();
}