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
 * Eo\EcommerceBundle\Document\Product\CustomProduct
 *
 * @ODM\Document
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class CustomProduct extends BaseCustomProduct
{
}
