<?php
namespace Millwright\ConfigurationBundle\Cache\Dumper;

/**
 * Data dumper adapter interface
 */
interface DumperInterface
{
    /**
     * Dump data
     *
     * @param mixed $data
     * @param array $options
     *
     * @return string
     */
    function dump($data, array $options = array());
}
