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
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Julius\EcommerceBundle\Document\Cart\BaseCart
 *
 * @ODM\MappedSuperclass
 */
class BaseCart implements CartInterface
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
    protected $user;

    /**
     * @ODM\EmbedMany
     */
    protected $items;

    /**
     * @var int $itemsTotal
     *
     * @ODM\Field(name="itemsTotal", type="int")
     */
    protected $itemsTotal = 0;

    /**
     * @var int $total
     *
     * @ODM\Field(name="total", type="int")
     */
    protected $total = 0;

    /**
     * @var string $state
     *
     * @ODM\Field(name="state", type="string")
     */
    protected $state;

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
        $this->items = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    /**
     * @ODM\PrePersist
     */
    public function prePersist()
    {
        $this->calculateTotal();
        $this->updatedAt = new DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function calculateTotal()
    {
        $this->calculateItemsTotal();
        $this->total = $this->itemsTotal;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateItemsTotal()
    {
        $itemsTotal = 0;
        foreach ($this->items as $item) {
            $item->calculateTotal();
            $itemsTotal += $item->getTotal();
        }
        $this->itemsTotal = $itemsTotal;
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
     * Set user
     *
     * @param  UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return UserInterface $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Has item
     *
     * @param  CartItemInterface $item
     * @return boolean
     */
    public function hasItem(CartItemInterface $item)
    {
        return $this->items->contains($item);
    }

    /**
     * Add cart item
     *
     * @param  CartItemInterface $item
     * @return self
     */
    public function addItem(CartItemInterface $item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Remove item
     *
     * @param  int     $key
     * @return boolean
     */
    public function removeItem($key)
    {
        return $this->items->remove($key);
    }

    /**
     * Remove item element
     *
     * @param  CartItemInterface $item
     * @return boolean
     */
    public function removeItemElement(CartItemInterface $item)
    {
        return $this->items->removeElement($item);
    }

    /**
     * Count items
     *
     * @return int
     */
    public function countItems()
    {
        return $this->items->count();
    }

    /**
     * Get items
     *
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set itemsTotal
     *
     * @param int $itemsTotal
     * @return self
     */
    public function setItemsTotal($itemsTotal)
    {
        $this->itemsTotal = $itemsTotal;
        return $this;
    }

    /**
     * Get itemsTotal
     *
     * @return int $itemsTotal
     */
    public function getItemsTotal()
    {
        return $this->itemsTotal;
    }

    /**
     * Set total
     *
     * @param int $total
     * @return self
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Get total
     *
     * @return int $total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set state
     *
     * @param  string $state
     * @return self
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get state
     *
     * @return string $state
     */
    public function getState()
    {
        return $this->state;
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
