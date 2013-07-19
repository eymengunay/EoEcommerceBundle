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

use Eo\EcommerceBundle\Document\Option\OptionInterface;
use Eo\EcommerceBundle\Document\Variant\VariantInterface;
use Eo\EcommerceBundle\Document\Price\PriceInterface;
use Eo\EcommerceBundle\Document\Condition\PriceConditionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Eo\EcommerceBundle\Document\Product\BaseCustomProduct
 *
 * @ODM\MappedSuperclass
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class BaseCustomProduct extends BaseProduct implements CustomProductInterface
{
    /**
     * @var PriceInterface $maxPrice
     */
    protected $maxPrice;

    /**
     * @var PriceInterface $minPrice
     */
    protected $minPrice;

    /**
     * @var ArrayCollection $prices
     *
     * @ODM\ReferenceMany
     */
    protected $prices;

    /**
     * @var ArrayCollection $priceConditions
     *
     * @ODM\EmbedMany
     */
    protected $priceConditions;

    /**
     * @var ArrayCollection $options
     */
    protected $options;

    /**
     * @var ArrayCollection $variants
     *
     * @ODM\ReferenceMany(mappedBy="product")
     */
    protected $variants;

    public function __construct()
    {
        $this->prices   = new ArrayCollection();
        $this->options  = new ArrayCollection();
        $this->variants = new ArrayCollection();
    }

    /**
     * Set maxPrice
     *
     * @param  PriceInterface $maxPrice
     * @return self
     */
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * Get maxPrice
     *
     * @return PriceInterface $maxPrice
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set minPrice
     *
     * @param  PriceInterface $minPrice
     * @return self
     */
    public function setMinPrice($minPrice)
    {
        $this->minPrice = $minPrice;
        return $this;
    }

    /**
     * Get minPrice
     *
     * @return PriceInterface $minPrice
     */
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * Has price
     *
     * @param bool
     */
    public function hasPrice(PriceInterface $price)
    {
        return $this->prices->contains($price);
    }

    /**
     * Add price
     *
     * @param PriceInterface $price
     */
    public function addPrice(PriceInterface $price)
    {
        if (!$this->hasPrice($price)) {
            $this->prices[] = $price;
        }
        return $this;
    }

    /**
     * Remove price
     *
     * @param PriceInterface $price
     */
    public function removePrice(PriceInterface $price)
    {
        $this->prices->removeElement($price);
        return $this;
    }

    /**
     * Clear all prices
     *
     * @return self
     */
    public function clearPrices()
    {
        $this->prices->clear();
        return $this;
    }

    /**
     * Set prices
     *
     * @param  $prices
     * @return self
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
        return $this;
    }

    /**
     * Get prices
     *
     * @return Doctrine\Common\Collections\Collection $prices
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * Has priceCondition
     *
     * @param bool
     */
    public function hasPriceCondition(PriceConditionInterface $priceCondition)
    {
        return $this->priceConditions->contains($priceCondition);
    }

    /**
     * Add priceCondition
     *
     * @param  PriceConditionInterface
     * @return self
     */
    public function addPriceCondition(PriceConditionInterface $priceCondition)
    {
        if (!$this->hasPriceCondition($priceCondition)) {
            $this->priceConditions->add($priceCondition);
        }
        return $this;
    }

    /**
     * Remove priceConditions
     *
     * @param PriceConditionInterface $priceCondition
     */
    public function removePriceCondition(PriceConditionInterface $priceCondition)
    {
        if ($this->hasPriceCondition($priceCondition)) {
            $this->priceConditions->removeElement($priceCondition);
        }
        return $this;
    }

    /**
     * Clear all priceConditions
     *
     * @return self
     */
    public function clearPriceConditions()
    {
        $this->priceConditions->clear();
        return $this;
    }

    /**
     * Set priceConditions
     *
     * @param  ArrayCollection $priceConditions
     * @return self
     */
    public function setPriceConditions(ArrayCollection $priceConditions)
    {
        return $this->priceConditions;
    }

    /**
     * Get priceConditions
     *
     * @return Doctrine\Common\Collections\Collection $priceConditions
     */
    public function getPriceConditions()
    {
        return $this->priceConditions;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption(OptionInterface $option)
    {
        return $this->options->contains($option);
    }

    /**
     * {@inheritdoc}
     */
    public function addOption(OptionInterface $option)
    {
        $this->options->add($option);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(ArrayCollection $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function hasVariant(VariantInterface $variant)
    {
        return $this->variants->contains($variant);
    }

    /**
     * {@inheritdoc}
     */
    public function addVariant(VariantInterface $variant)
    {
        $this->variants->add($variant);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setVariants(ArrayCollection $variants)
    {
        $this->variants = $variants;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clearVariants()
    {
        $this->variants->clear();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVariants()
    {
        return $this->variants;
    }
}
