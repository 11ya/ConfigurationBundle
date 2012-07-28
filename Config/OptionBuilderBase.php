<?php
namespace Millwright\ConfigurationBundle\Config;

/**
 * Option builder base class
 */
abstract class OptionBuilderBase implements OptionBuilderInterface
{
    protected $defaultOptions = array();

    /**
     * {@inheritDoc}
     */
    public function build()
    {
        return $this->defaultOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaults(array $defaultOptions)
    {
        $this->defaultOptions = $defaultOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function isCacheable()
    {
        return true;
    }
}
