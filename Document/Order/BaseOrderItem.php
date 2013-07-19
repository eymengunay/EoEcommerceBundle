<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Document\Order;

use Eo\EcommerceBundle\Document\Product\ProductInterface;
use Eo\EcommerceBundle\Document\Price\PriceInterface;
use Eo\EcommerceBundle\Document\Variant\VariantInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Eo\EcommerceBundle\Document\Order\BaseOrderItem
 *
 * @ODM\MappedSuperclass
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class BaseOrderItem implements OrderItemInterface
{
    /**
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @ODM\String
     */
    protected $type;

    /**
     * @ODM\ReferenceOne
     */
    protected $product;

    /**
     * @ODM\ReferenceOne
     */
    protected $variant;

    /**
     * @ODM\EmbedOne(targetDocument="Eo\EcommerceBundle\Document\Price\EmbeddedPrice")
     */
    protected $price;

    /**
     * @ODM\Int
     */
    protected $quantity;

    /**
     * @ODM\Int
     */
    protected $unitPrice;

    /**
     * @ODM\Int
     */
    protected $total;

    public function __construct()
    {
        $this->quantity = 0;
        $this->unitPrice = 0;
        $this->total = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateTotal()
    {
        $this->total = ($this->quantity * $this->getUnitPrice());
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;

        // Set type from product object
        if ($product->getType() && is_null($this->getType())) {
            $this->setType($product->getType());
        }

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
     * {@inheritdoc}
     */
    public function setVariant(VariantInterface $variant)
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * {@inheritdoc}
     */
    public function setPrice(PriceInterface $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuantity($quantity)
    {
        if (0 > $quantity) {
            throw new \OutOfRangeException('Quantity must be greater than 0');
        }
        $this->quantity = $quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitPrice()
    {
        if ($price = $this->getPrice()) {
            return $price->getPrice();
        }

        return $this->unitPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal()
    {
        return $this->total;
    }
}
