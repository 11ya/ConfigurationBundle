<?php
namespace Millwright\ConfigurationBundle\Config\Adapter\Dumper;

/**
 * Array dumper
 */
class ArrayDumper implements DumperInterface
{
    /**
     * {@inheritDoc}
     */
    public function dump($data, array $options = array())
    {
        return '<?php return ' . var_export($data, true) . ';';
    }
}
