<?php
namespace Millwright\ConfigurationBundle\Config\Adapter\Dumper;

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
     * @return mixed
     */
    function dump($data, array $options = array());
}
