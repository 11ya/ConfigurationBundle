<?php
namespace Millwright\ConfigurationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Millwright\ConfigurationBundle\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MillwrightConfigurationExtension extends Extension
{
    protected $bundleRoot = __DIR__;
}
