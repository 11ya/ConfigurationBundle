<?php
namespace Millwright\ConfigurationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

use Millwright\ConfigurationBundle\ContainerUtil as Util;
/**
 * FormCompilerPass
 */
class AddBuildersCompilerPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        Util::addDefinitionsToService(
            'millwright_configuration.dumper',
            'millwright_configuration.cache.adapter',
            3,
            $container
        );

        Util::addDefinitionsToService(
            'millwright_configuration.builder',
            'millwright_configuration.manager',
            1,
            $container
        );
    }
}
