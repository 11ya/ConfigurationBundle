<?php
namespace Millwright\ConfigurationBundle\Builder;

/**
 * Option registry
 */
interface OptionRegistryInterface
{
    /**
     * Add option to namespace
     *
     * @param string $namespace
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    function addOption($namespace, $key, $value);

    /**
     * Get all stored options array
     *
     * @param string|null $namespace
     *
     * @return string[string]
     */
    function getOptions($namespace = null);
}
