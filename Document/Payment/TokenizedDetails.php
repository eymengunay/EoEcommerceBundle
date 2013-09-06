<?php

namespace Eo\EcommerceBundle\Document\Payment;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Payum\Model\TokenizedDetails as BaseTokenizedDetails;

/**
 * @ODM\Document
 */
class TokenizedDetails extends BaseTokenizedDetails
{
	/**
     * @ODM\Id(strategy="auto")
     */
    protected $id;

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
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
}