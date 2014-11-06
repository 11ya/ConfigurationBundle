<?php
namespace Millwright\ConfigurationBundle\Cache;

/**
 * Config cache implementation
 */
class ApcCache implements CacheAdapterInterface
{
    protected $ttl = 60;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * Constructor
     *
     * @param integer $ttl
     * @param string  $namespace
     */
    public function __construct($ttl, $namespace = '')
    {
        $this->ttl       = $ttl;
        $this->namespace = $namespace;
    }

    /**
     * {@inheritDoc}
     */
    public function warm($key, array $data, array $options = array())
    {
        $this->write($key, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function write($key, array $data)
    {
        apc_store($this->getKey($key), $data, $this->ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function read($key, &$success)
    {
        return apc_fetch($this->getKey($key), $success);
    }

    protected function getKey($key)
    {
        return $this->namespace . $key;
    }
}
