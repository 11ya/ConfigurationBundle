<?php
namespace Millwright\ConfigurationBundle\Builder;

/**
 * Option manager interface
 */
interface OptionManagerInterface
{
    /**
     * Get options from cache or build
     *
     * @param string $key options namespace key
     *
     * @return array
     */
    function getOptions($key);

    /**
     * Warm up all options
     *
     * @param array $options warm up specific option
     *
     * @return void
     */
    function warmUp(array $options);
}
