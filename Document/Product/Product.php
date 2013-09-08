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

use \DateTime;
use Eo\EcommerceBundle\Document\Price\PriceInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints as ODMConstraints;

/**
 * Eo\EcommerceBundle\Document\Product\Product
 *
 * @ODM\Document
 * @ODMConstraints\Unique("sku")
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Product extends BaseProduct
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;
}
