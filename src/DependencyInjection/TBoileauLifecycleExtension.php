<?php

namespace TBoileau\LifecycleBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class TBoileauLifecycleExtension
 * @package TBoileau\LifecycleBundle\DependencyInjection
 * @author Thomas Boileau <t-boileau@email.com>
 */
class TBoileauLifecycleExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load("services.yaml");
    }

}