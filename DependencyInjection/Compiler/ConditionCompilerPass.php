<?php

namespace Eo\EcommerceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ConditionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('eo_ecommerce.condition_manager')) {
            return;
        }

        $definition = $container->getDefinition(
            'eo_ecommerce.condition_manager'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'eo_ecommerce.condition'
        );
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addCondition',
                array(new Reference($id))
            );
        }
    }
}