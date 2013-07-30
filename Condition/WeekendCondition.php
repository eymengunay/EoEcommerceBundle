<?php

namespace Eo\EcommerceBundle\Condition;

use Eo\EcommerceBundle\Document\Product\CustomProductInterface;

/**
 * An example condition implementation.
 * It will return true only on Saturday and Sunday.
 */
class WeekendCondition extends BaseCondition
{
	/**
	 * {@inheritdoc}
	 */
    public function met(CustomProductInterface $product)
    {
        $date = new \DateTime();
    	return $date->format('N') >= 6;
    }
}