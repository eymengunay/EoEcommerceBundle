<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\EventListener;

use Eo\EcommerceBundle\Generator\VariantGeneratorInterface;
use Eo\EcommerceBundle\Document\Variant\VariantInterface;
use Eo\EcommerceBundle\Document\Product\CustomProductInterface;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

class DoctrineListener
{
    /**
     * @var VariantGeneratorInterface
     */
    protected $vg;

    /**
     * Class cosntructor
     *
     * @param VariantGeneratorInterface $vg
     */
    public function __construct(VariantGeneratorInterface $vg)
    {
        $this->vg = $vg;
    }

    /**
     * On document prePersist
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        // Get object from doctrine event
        $object = $eventArgs->getDocument();
        // Only custom products can have variants
        if (!$object instanceof CustomProductInterface or $object instanceof VariantInterface) return;
        // Generate variants
        //$this->vg->generate($object);
    }
}