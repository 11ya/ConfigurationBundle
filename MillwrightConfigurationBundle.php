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
     * {@inheritDoc}
     */
    public function boot()
    {
        if (!interface_exists('JsonSerializable')) {
            include __DIR__ . DIRECTORY_SEPARATOR . 'Workaround' . DIRECTORY_SEPARATOR . 'JsonSerializable.php';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddBuildersCompilerPass());
    }
}
