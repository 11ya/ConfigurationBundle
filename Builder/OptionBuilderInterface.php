<?php
namespace Millwright\ConfigurationBundle\Builder;

/**
 * Option builder interface
 */
interface OptionBuilderInterface
{
    /**
     * Build options
     *
     * @return array
     */
    function build();

    /**
     * Set default options to builder
     *
     * @param array $options
     *
     * @return array normalized and builded options
     */
    function setDefaults(array $options);

    /**
     * Is options can be cached in option manager ?
     *
     * @return boolean
     */
    function isCacheable();
}
