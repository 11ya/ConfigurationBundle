<?php
namespace Millwright\ConfigurationBundle\Builder;

/**
 * Option registry
 */
class OptionRegistry implements OptionRegistryInterface
{
    protected $options = array();
    protected $plainOptions = array();

    /**
     * {@inheritDoc}
     */
    public function addOption($namespace, $key, $value)
    {
        $this->options[$namespace][$key] = $value;
        $this->plainOptions[$key]        = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions($namespace = null)
    {
        return $namespace ? $this->options[$namespace] : $this->plainOptions;
    }
}
