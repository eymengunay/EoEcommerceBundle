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
 * Eo\EcommerceBundle\Document\Product\BaseProduct
 *
 * @ODM\MappedSuperclass
 * @ODMConstraints\Unique("sku")
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class BaseProduct implements ProductInterface
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ODM\Field(name="name", type="string")
     */
    protected $name;

    /**
     * @var string $slug
     *
     * @ODM\Field(name="slug", type="string")
     */
    protected $slug;

    /**
     * @var string $sku
     *
     * @ODM\Field(name="sku", type="string")
     */
    protected $sku;

    /**
     * @var string $description
     *
     * @ODM\Field(name="description", type="string")
     */
    protected $description;

    /**
     * @var string $type
     *
     * @ODM\Field(name="type", type="string")
     */
    protected $type;

    /**
     * @ODM\ReferenceOne
     */
    protected $price;

    /**
     * @var bool $isSellable
     *
     * @ODM\Field(name="isSellable", type="boolean")
     */
    protected $isSellable;

    /**
     * @var date $availableAt
     *
     * @ODM\Field(name="availableAt", type="date")
     */
    protected $availableAt;

    /**
     * @var date $createdAt
     *
     * @ODM\Field(name="createdAt", type="date")
     */
    protected $createdAt;

    /**
     * @var date $updatedAt
     *
     * @ODM\Field(name="updatedAt", type="date")
     */
    protected $updatedAt;

    /**
     * @var date $deletedAt
     *
     * @ODM\Field(name="deletedAt", type="date")
     */
    protected $deletedAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @ODM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new DateTime();
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
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set sku
     *
     * @param string $sku
     * @return self
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * Get sku
     *
     * @return string $sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set price
     *
     * @param PriceInterface $price
     * @return self
     */
    public function setPrice(PriceInterface $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return PriceInterface $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isSellable
     *
     * @param  bool $isSellable
     * @return self
     */
    public function setIsSellable($isSellable)
    {
        $this->isSellable = $isSellable;
        return $this;
    }

    /**
     * Get isSellable
     *
     * @return bool
     */
    public function getIsSellable()
    {
        return $this->isSellable;
    }

    /**
     * Set availableAt
     *
     * @param DateTime $availableAt
     * @return self
     */
    public function setAvailableAt(DateTime $availableAt)
    {
        $this->availableAt = $availableAt;
        return $this;
    }

    /**
     * Get availableAt
     *
     * @return DateTime $availableAt
     */
    public function getAvailableAt()
    {
        return $this->availableAt;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     * @return self
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     * @return self
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return DateTime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param DateTime $deletedAt
     * @return self
     */
    public function setDeletedAt(DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return DateTime $deletedAt
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
