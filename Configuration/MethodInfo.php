<?php
namespace Millwright\ConfigurationBundle\Configuration;

/**
 * Get method arguments and annotations
 */
class MethodInfo
{
    protected $arguments;
    protected $configurations;

    /**
     * Constructor
     *
     * @param array $arguments
     * @param array $configurations
     */
    public function __construct(array $arguments, array $configurations)
    {
        $this->arguments      = $arguments;
        $this->configurations = $configurations;
    }

    /**
     * Get method arguments
     *
     * @return array[method name]
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Get method configurations, aggregated by annotation class name
     *
     * @return array[annotation class name][]
     */
    public function getConfigurations()
    {
        return $this->configurations;
    }
}
