<?php

/*
 * This file is part of the JuliusEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Document\Cart;

use \DateTime;
use Eo\EcommerceBundle\Document\Product\ProductInterface;
use Eo\EcommerceBundle\Document\Price\PriceInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Eo\EcommerceBundle\Document\Cart\BaseCartItem
 *
 * @ODM\MappedSuperclass
 */
class BaseCartItem implements CartItemInterface
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @ODM\ReferenceOne
     */
    protected $product;

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

    /**
     * @ODM\Date
     */
    protected $createdAt;

    /**
     * @ODM\Date
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @ODM\PrePersist
     */
    public function prePersist()
    {
        $this->updatedAt = new DateTime();
        $this->calculateTotal();
    }

    /**
     * {@inheritdoc}
     */
    public function calculateTotal()
    {
        $this->total = ($this->quantity * $this->getUnitPrice() ?: 0);
        return $this;
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set product
     *
     * @param  ProductInterface $product
     * @return self
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;

        // Set cart item price
        if ($price = $this->product->getPrice()) {
            $this->setUnitPrice($price->getPrice());
        } else {
            throw new \Exception(sprintf("Product doesn't have any price"));
        }

        return $this;
    }

    /**
     * Get product
     *
     * @return string $product
     */
    public function getProduct()
    {
        return $this->product;
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

    /**
     * Set createdAt
     *
     * @param  date     $createdAt
     * @return \Content
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param  date         $updatedAt
     * @return \LoyaltyCard
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
