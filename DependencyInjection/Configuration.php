<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('eo_ecommerce');

        $rootNode
            ->children()
                ->arrayNode('prices')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('resolve_onload')->defaultTrue()->end()
                    ->end()
                ->end()
                ->arrayNode('orders')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue("Eo\EcommerceBundle\Document\Order\Order")->end()
                        ->arrayNode('items')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->defaultValue("Eo\EcommerceBundle\Document\Order\OrderItem")->end()
                                ->arrayNode('prices')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('class')->defaultValue("Eo\EcommerceBundle\Document\Price\EmbeddedPrice")->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('priceConditions')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->isRequired()->end()
                    ->end()
                ->end()
                ->arrayNode('variants')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue("Eo\EcommerceBundle\Document\Variant\Variant")->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
