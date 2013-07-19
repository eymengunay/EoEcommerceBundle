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

use Eo\EcommerceBundle\Document\Product\BaseCustomProduct;
use Eo\EcommerceBundle\Document\Product\ProductInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Eo\EcommerceBundle\Document\Variant\BaseVariant
 *
 * @ODM\MappedSuperclass
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class BaseVariant extends BaseCustomProduct implements VariantInterface
{
    /**
     * @ODM\ReferenceOne(inversedBy="variants")
     */
    protected $product;

    /**
     * {@inheritdoc}
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Get prices
     *
     * Variants can have their own prices separated from the parent prodocut.
     * Therefore if current variant has any prices the method will return them,
     * otherwise it will fallback to variants parent product prices.
     * With this fallback it is easier to have different prices for each
     * product option value.
     *
     * @return Doctrine\Common\Collections\Collection $prices
     */
    public function getPrices3()
    {
        if (is_null($this->prices) or empty($this->prices)) {
            if ($product = $this->getProduct()) {
                return $product->getPrices();
            }
        }
        return $this->prices;
    }
}
