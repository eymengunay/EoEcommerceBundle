<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Document\Condition;

use Eo\EcommerceBundle\Document\Product\ProductInterface;

interface ConditionInterface
{
    /**
     * Check condition
     *
     * @param  ProductInterface $product
     * @return bool
     */
    public function check(ProductInterface $product);
}