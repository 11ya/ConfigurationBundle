<?php
namespace Millwright\ConfigurationBundle;

use Symfony\Component\HttpKernel\DependencyInjection\Extension as ExtensionBase;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Base rad extension
 */
abstract class Extension extends ExtensionBase
{
    protected $configRoot  = __DIR__;
    protected $isYml       = true;
    protected $dbDriverMap = array(
        'orm'     => 'getOrmConfigParts',
        'mongodb' => 'getOdmConfigParts'
    );

    /**
     * Get configuration files array
     *
     * @return array
     */
    protected function getConfigParts()
    {
        return array(
            'services.yml',
        );
    }

    /**
     * Get configuration files array if orm detected
     *
     * @return array
     */
    protected function getOrmConfigParts()
    {
        return array();
    }

    /**
     * Get configuration files array if odm detected
     *
     * @return array
     */
    protected function getOdmConfigParts()
    {
        return array();
    }

    /**
     * Get configuration files root directory
     *
     * @return string
     */
    protected function getConfigRoot()
    {
        return dirname($this->configRoot) . '/Resources/config';
    }

    /**
     * Get file loader
     *
     * @param ContainerBuilder $container
     *
     * @return Loader\XmlFileLoader|Loader\YamlFileLoader
     */
    protected function getLoader(ContainerBuilder $container)
    {
        $locator = new FileLocator($this->getConfigRoot());

        return $this->isYml
            ? new Loader\YamlFileLoader($container, $locator)
            : new Loader\XmlFileLoader($container, $locator);
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration(array(), $container);
        $config        = $configuration
            ? $this->processConfiguration($configuration, $configs)
            : array();

        $loader = $this->getLoader($container);

        foreach ($this->getConfigParts() as $part) {
            $loader->load($part);
        }

        $driver = isset($config['db_driver']) ? $config['db_driver'] : 'orm';
        $method = $this->dbDriverMap[$driver];

        foreach ($this->$method() as $part) {
            $loader->load($part);
        }

        if ($config) {
            $this->copyParameters($config, $container);
        }
    }

    /**
     * Copy parameters from config to container
     *
     * @param array            $config app config
     * @param ContainerBuilder $container
     */
    protected function copyParameters(array $config, ContainerBuilder $container)
    {
        foreach ($config as $key => $value) {
            $key = $this->getAlias() . '.' . $key;
            $container->setParameter($key, $value);
        }
    }
}
