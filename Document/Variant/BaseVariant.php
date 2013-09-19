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
use Eo\EcommerceBundle\Document\Option\OptionValueInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Eo\EcommerceBundle\Document\Variant\BaseVariant
 *
 * @ODM\MappedSuperclass
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class BaseVariant extends BaseCustomProduct implements VariantInterface
{
    /**
     * @var string $fullName
     *
     * @ODM\Field(name="fullName", type="string")
     */
    protected $fullName;

    /**
     * @ODM\ReferenceOne(inversedBy="variants")
     */
    protected $product;

    /**
     * @ODM\ReferenceMany()
     */
    protected $optionValues;

    public function __construct()
    {
        parent::__construct();
        $this->optionValues  = new ArrayCollection();
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     * @return self
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * Get fullName
     *
     * @return string $fullName
     */
    public function getFullName()
    {
        return $this->fullName;
    }

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

    /**
     * {@inheritdoc}
     */
    public function hasOptionValue(OptionValueInterface $optionValue)
    {
        return $this->optionValues->contains($optionValue);
    }

    /**
     * {@inheritdoc}
     */
    public function addOptionValue(OptionValueInterface $optionValue)
    {
        $this->optionValues->add($optionValue);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptionValues(ArrayCollection $optionValues)
    {
        $this->optionValues = $optionValues;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionValues()
    {
        return $this->optionValues;
    }
}
