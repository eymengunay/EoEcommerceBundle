<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Document\Price;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Eo\EcommerceBundle\Document\Price\EmbeddedPrice
 *
 * @ODM\EmbeddedDocument
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class EmbeddedPrice extends BasePrice implements EmbeddedPriceInterface
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * Createsa  new EmbeddedPrice class from PriceInterface
     *
     * @param  PriceInterface $price
     * @return self
     */
    public function loadFromParent(PriceInterface $price)
    {
        $this->setName($price->getName());
        $this->setPrice($price->getPrice());
        $this->setCreatedAt($price->getCreatedAt());
        $this->setUpdatedAt($price->getUpdatedAt());
        return $this;
    }
}
