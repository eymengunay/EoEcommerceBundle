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

use Eo\EcommerceBundle\Resolver\PriceResolver;
use Eo\EcommerceBundle\Document\Variant\VariantInterface;
use Eo\EcommerceBundle\Generator\VariantGeneratorInterface;
use Eo\EcommerceBundle\Document\Product\CustomProductInterface;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DoctrineListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Class cosntructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * On document prePersist
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->variantGenerator($eventArgs);
    }

    /**
     * On document postLoad
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $this->priceResolver($eventArgs);
    }

    /**
     * Variant generator
     * 
     * @param LifecycleEventArgs $eventArgs
     */
    protected function variantGenerator(LifecycleEventArgs $eventArgs)
    {
        // Get object from doctrine event
        $object = $eventArgs->getDocument();
        // Only custom products can have variants
        if (!$object instanceof CustomProductInterface or $object instanceof VariantInterface) return;
        // Generate variants
        $this->container->get('eo_ecommerce.variant_generator')->generate($object);
    }

    /**
     * Price resolver
     *
     * @param LifecycleEventArgs $eventArgs
     */
    protected function priceResolver(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getDocument();
        $pr = $this->container->get('eo_ecommerce.price_resolver');

        if ($object instanceof VariantInterface) {
            // Resolve price
            $pr->resolve($object);
            $pr->addResolvable($object);
        } elseif ($object instanceof CustomProductInterface) {
            // Set min/max
            $pr->addMinMax($object);
        }
    }
}