<?php
namespace Millwright\ConfigurationBundle\Cache;

/**
 * Options cache adapter interface
 */
interface CacheAdapterInterface
{
    /**
     * Read data from cache
     *
     * @param string  $key
     * @param boolean &$success
     *
     * @return array
     */
    function read($key, &$success);

    /**
     * Write data to cache
     *
     * @param string $key
     * @param array  $data
     *
     * @return void
     */
    function write($key, array $data);

    /**
     * Warmp up cache
     *
     * @param string $key
     * @param array  $data
     * @param array  $options additional options for cache warming
     *
     * @return void
     */
    function warm($key, array $data, array $options = array());
}
