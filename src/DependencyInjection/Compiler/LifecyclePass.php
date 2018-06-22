<?php

namespace TBoileau\LifecycleBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use TBoileau\LifecycleBundle\Configurator;

class LifecyclePass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('t_boileau.lifecycle');


        foreach($taggedServices as $id => $attributes) {
            $definition = $container->getDefinition($id);

            if($container->has("security.authorization_checker")) {
                $definition->addMethodCall('setAuthorizationChecker', [new Reference("security.authorization_checker")]);
            }

            if($container->has("twig")) {
                $definition->addMethodCall('setTwig', [new Reference("twig")]);
            }

            if($container->has("router")) {
                $definition->addMethodCall('setRouter', [new Reference("router")]);
            }
        }
    }
}