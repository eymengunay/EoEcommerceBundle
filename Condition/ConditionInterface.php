<?php

namespace Eo\EcommerceBundle\Condition;

use Eo\EcommerceBundle\Document\Product\CustomProductInterface;

interface ConditionInterface
{
    public function met(CustomProductInterface $product);

    public function getName();
}