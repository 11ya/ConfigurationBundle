<?php
namespace Millwright\ConfigurationBundle\Twig;

use Millwright\Util\Request\OptionRegistryInterface;

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
            'options_query'    => new \Twig_Function_Method($this, 'getQuery'),
        );
    }

    /**
     * Gets all stored in registry options
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
     * Gets all stored in registry options as a GET query (?q=w&e=r)
     *
     * @param  string $namespace
     * @param  array  $overrides
     *
     * @return string
     */
    public function getQuery($namespace, array $overrides = null)
    {
        return $this->options->getQuery($namespace, $overrides);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'millwright_configuration';
    }
}
