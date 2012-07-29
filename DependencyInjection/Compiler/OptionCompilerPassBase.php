<?php
namespace Millwright\ConfigurationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Config\Definition\Processor;
use Millwright\ConfigurationBundle\ContainerUtil;

/**
 * Options compiler pass
 * Collect options, tagged by $optionsTag
 * And set them to option builder with id $optionBuilderId
 */
abstract class OptionCompilerPassBase implements CompilerPassInterface
{
    protected $optionBuilderId;
    protected $optionsTag;

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->optionBuilderId)) {
            return;
        }

        $processor = new Processor();
        $config    = ContainerUtil::collectConfiguration($this->optionsTag, $container);
        $this->preProcess($config, $processor, $container);
        $container->getDefinition($this->optionBuilderId)->addMethodCall('setDefaults', array($config));
    }

    /**
     * Preprocess config before set defaults to option builder
     *
     * @param array            $config
     * @param Processor        $processor
     * @param ContainerBuilder $container
     */
    protected function preProcess(array & $config, Processor $processor, ContainerBuilder $container)
    {
    }
}
