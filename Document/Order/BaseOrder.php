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

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Eo\EcommerceBundle\Document\Order\BaseOrder
 *
 * @ODM\MappedSuperclass
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class BaseOrder implements OrderInterface
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $number
     *
     * @ODM\Field(name="number", type="string")
     */
    protected $number;

    /**
     * @var collection $items
     *
     * @ODM\ReferenceMany(mappedBy="order")
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
     * @ODM\ReferenceOne
     */
    protected $user;

    /**
     * Creation time.
     *
     * @ODM\Date
     */
    protected $createdAt;

    /**
     * Modification time.
     *
     * @ODM\Date
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt = new DateTime();
        $this->number = $this->generateUniqueNumber();
    }

    /**
     * @ODM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * @ODM\PrePersist
     */
    public function prePersist()
    {
        $this->calculateTotal();
    }

    /**
     * Generates a unique order number
     *
     * @return string
     */
    public function generateUniqueNumber()
    {
        return strtoupper(str_replace(".", "", uniqid(rand(), 1)));
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
     * Set number
     *
     * @param string $number
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Get number
     *
     * @return string $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Has item
     *
     * @param OrderItemInterface $item
     * @return bool
     */
    public function hasItem(OrderItemInterface $item)
    {
        return $this->items->contains($item);
    }

    /**
     * Add item
     *
     * @param OrderItemInterface $item
     * @return self
     */
    public function addItem(OrderItemInterface $item)
    {
        if (!$this->hasItem($item)) {
            $this->items->add($item);
        }
        return $this;
    }

    /**
     * Remove item
     *
     * @param OrderItemInterface $item
     * @return bool
     */
    public function removeItem(OrderItemInterface $item)
    {
        return $this->items->removeElement($item);
    }

    /**
     * Set items
     *
     * @param ArrayCollection $items
     * @return self
     */
    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Get items
     *
     * @return ArrayCollection $items
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
     * @param string $state
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
     * Set user
     *
     * @param  UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user = null)
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
     * {@inheritdoc}
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
