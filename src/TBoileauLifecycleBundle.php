<?php

namespace TBoileau\LifecycleBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TBoileau\LifecycleBundle\DependencyInjection\Compiler\LifecyclePass;

/**
 * Class TBoileauLifecycleBundle
 * @package TBoileau\LifecycleBundle
 * @author Thomas Boileau <t-boileau@email.com>
 */
class TBoileauLifecycleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new LifecyclePass());
    }

}