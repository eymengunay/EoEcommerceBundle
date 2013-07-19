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
     * @ODM\Hash
     */
    protected $conditions;

    /**
     * @ODM\ReferenceOne
     */
    protected $price;

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
     * Set conditions
     *
     * @param hash $conditions
     * @return self
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * Get conditions
     *
     * @return hash $conditions
     */
    public function getConditions()
    {
        return $this->conditions;
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
}