<?php
namespace Millwright\ConfigurationBundle\Cache;

/**
 * Config cache implementation
 */
class ApcCache implements CacheAdapterInterface
{
    protected $ttl = 60;

    /**
     * Constructor
     *
     * @param integer $ttl
     */
    public function __construct($ttl)
    {
        $this->ttl = $ttl;
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
        apc_store($key, $data, $this->ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function read($key, &$success)
    {
        return apc_fetch($key, $success);
    }
}
