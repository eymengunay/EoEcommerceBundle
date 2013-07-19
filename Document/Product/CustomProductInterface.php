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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Eo\EcommerceBundle\Document\Product\CustomProductInterface
 */
interface CustomProductInterface extends ProductInterface
{
    /**
     * Has option
     *
     * @param  OptionInterface $option
     * @return bool
     */
    public function hasOption(OptionInterface $option);

    /**
     * Add option
     *
     * @param  OptionInterface $option
     * @return self
     */
    public function addOption(OptionInterface $option);

    /**
     * Set options
     *
     * Here's an example of size/color options implementation:
     * <code>
     * // Create size option
     * $sizeOption = new ProductOption();
     * $sizeOption->setName('Size');
     * $sizeOption->setMethod('getSizes');
     * // Create color option
     * $colorOption = new ProductOption();
     * $colorOption->setName('Color');
     * $colorOption->setMethod('getColors');
     * // Set options
     * $this->setOptions(new ArrayCollection($sizeOption, $colorOption));
     * return $this;
     * </code>
     *
     * @param  array $options
     * @return self
     */
    public function setOptions(ArrayCollection $options);

    /**
     * Get options
     *
     * @return ArrayCollection $options
     */
    public function getOptions();

    /**
     * Has variant
     *
     * @param  VariantInterface $variant
     * @return bool
     */
    public function hasVariant(VariantInterface $variant);

    /**
     * Add variant
     *
     * @param  VariantInterface $variant
     * @return self
     */
    public function addVariant(VariantInterface $variant);

    /**
     * Set variants
     *
     * @param  ArrayCollection $variants
     * @return self
     */
    public function setVariants(ArrayCollection $variants);

    /**
     * Get variants
     *
     * @return ArrayCollection $variants
     */
    public function getVariants();
}