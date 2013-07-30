<?php

namespace Eo\EcommerceBundle\Condition;

abstract class BaseCondition implements ConditionInterface
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
}