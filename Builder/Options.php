<?php
namespace Millwright\ConfigurationBundle\Builder;

/**
 * Options container class
 */
class Options
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function get()
    {
        return $this->options;
    }
}
