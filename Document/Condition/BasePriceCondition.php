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

use \DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\MappedSuperclass
 */
abstract class BasePriceCondition implements PriceConditionInterface
{
    /**
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @ODM\ReferenceMany(targetDocument="Eo\EcommerceBundle\Document\Variant\Variant")
     */
    protected $variants;

    /**
     * @ODM\String
     */
    protected $condition;

    /**
     * @ODM\ReferenceOne(targetDocument="Eo\EcommerceBundle\Document\Price\Price")
     */
    protected $price;

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
        $this->variants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conditions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new DateTime();
    }

    /**
     * @ODM\PrePersist
     */
    public function prePersist()
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add variants
     *
     * @param $variants
     */
    public function addVariant($variants)
    {
        $this->variants[] = $variants;
    }

    /**
    * Remove variants
    *
    * @param <variableType$variants
    */
    public function removeVariant($variants)
    {
        $this->variants->removeElement($variants);
    }

    /**
     * Get variants
     *
     * @return Doctrine\Common\Collections\Collection $variants
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * Add conditions
     *
     * @param Eo\EcommerceBundle\Document\Condition\Condition $conditions
     */
    public function addCondition($conditions)
    {
        $this->conditions[] = $conditions;
    }

    /**
    * Remove conditions
    *
    * @param <variableType$conditions
    */
    public function removeCondition($conditions)
    {
        $this->conditions->removeElement($conditions);
    }

    /**
     * Get conditions
     *
     * @return Doctrine\Common\Collections\Collection $conditions
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set condition
     *
     * @param  string $condition
     * @return self
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
        return $this;
    }

    /**
     * Get condition
     *
     * @return string $condition
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Set price
     *
     * @param $price
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return $price
     */
    public function getPrice()
    {
        return $this->price;
    }

     /**
     * Set createdAt
     *
     * @param  DateTime $createdAt
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
     * @param  DateTime $updatedAt
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
}