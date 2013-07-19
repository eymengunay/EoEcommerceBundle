<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Document\Option;

/**
 * Eo\EcommerceBundle\Document\Option\OptionInterface
 */
interface OptionInterface
{
    /**
     * Set name
     *
     * @param  string $name
     * @return self
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName();

    /**
     * Set method
     *
     * @param  string $method
     * @return self
     */
    public function setMethod($method);

    /**
     * Get method
     *
     * @return string $method
     */
    public function getMethod();
}