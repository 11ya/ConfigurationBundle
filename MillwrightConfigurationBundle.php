<?php
namespace Millwright\ConfigurationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Millwright\ConfigurationBundle\DependencyInjection\Compiler\AddBuildersCompilerPass;

/**
 * Configuration bundle
 */
class MillwrightConfigurationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddBuildersCompilerPass());
    }
}
