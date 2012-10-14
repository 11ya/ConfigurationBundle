<?php
namespace Millwright\ConfigurationBundle\Twig;

use Millwright\ConfigurationBundle\Builder\OptionRegistryInterface;

/**
 * Twig extension for Bootstrap helpers
 */
class ConfigurationExtension extends \Twig_Extension
{
    protected $options;

    /**
     * Constructor
     *
     * @param OptionRegistryInterface $options
     */
    public function __construct(OptionRegistryInterface $options)
    {
        $this->options = $options;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'options_registry' => new \Twig_Function_Method($this, 'getOptions'),
        );
    }

    /**
     * Get all stored in registry options
     *
     * @param  string|null $namespace
     *
     * @return string[string]
     */
    public function getOptions($namespace = null)
    {
        return $this->options->getOptions($namespace);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'millwright_configuration';
    }
}
