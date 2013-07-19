<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Document\Option;

use Eo\EcommerceBundle\Document\Price\PriceInterface;
use Eo\EcommerceBundle\Document\Product\BaseCustomProduct;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Eo\EcommerceBundle\Document\Option\BaseOptionValue
 *
 * @ODM\MappedSuperclass
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class BaseOptionValue extends BaseCustomProduct
{
    /**
     * @var array $variantPrices
     */
    protected $variantPrices = array();

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Has variantPrice
     *
     * @param bool
     */
    public function hasVariantPrice(PriceInterface $variantPrice)
    {
        return isset($this->variantPrices[$variantPrice->getId()]);
    }

    /**
     * Add variantPrice
     *
     * @param PriceInterface $variantPrice
     */
    public function addVariantPrice(PriceInterface $variantPrice)
    {
        if (!$this->hasVariantPrice($variantPrice)) {
            $this->variantPrices[$variantPrice->getId()] = $variantPrice;
        }
        return $this;
    }

    /**
     * Remove variantPrice
     *
     * @param PriceInterface $variantPrice
     */
    public function removeVariantPrice(PriceInterface $variantPrice)
    {
        if ($this->hasVariantPrice($variantPrice)) {
            unset($this->variantPrices[$variantPrice->getId()]);
        }
        return $this;
    }

    /**
     * Clear variantPrices
     */
    public function clearVariantPrices()
    {
        $this->variantPrices = array();
        return $this;
    }

    /**
     * Set variantPrices
     *
     * @param  array $variantPrices
     * @return self
     */
    public function setVariantPrices(array $variantPrices)
    {
        $data = array();
        foreach ($variantPrices as $variantPrice) {
            $data[$variantPrice->getId()] = $variantPrice;
        }
        $this->variantPrices = $data;
        return $this;
    }

    /**
     * Get variantPrices
     *
     * @return Doctrine\Common\Collections\Collection $variantPrices
     */
    public function getVariantPrices()
    {
        return $this->variantPrices;
    }
}
