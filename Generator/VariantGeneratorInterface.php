<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Generator;

use Eo\EcommerceBundle\Document\Product\CustomProductInterface;

interface VariantGeneratorInterface
{
    /**
     * Generate variants
     *
     * @todo  Add multiple product option support.
     * @param CustomProductInterface $product
     */
    public function generate(CustomProductInterface $product);
}