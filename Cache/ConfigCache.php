<?php
namespace Millwright\ConfigurationBundle\Cache;

use Symfony\Component\Config\ConfigCache as SymfonyConfigCache;

use Millwright\ConfigurationBundle\Cache\Dumper\DumperInterface;

/**
 * Config cache implementation
 */
class ConfigCache implements CacheAdapterInterface
{
    protected $cacheDir;
    protected $debug;
    protected $dumpers;
    protected $classPrefix;

    /**
     * Constructor
     *
     * @param string            $cacheDir
     * @param boolean           $debug
     * @param string            $classPrefix
     * @param DumperInterface[] $dumpers
     */
    public function __construct($cacheDir, $debug, $classPrefix, array $dumpers)
    {
        $this->cacheDir    = $cacheDir;
        $this->debug       = $debug;
        $this->classPrefix = $classPrefix;
        $this->dumpers     = $dumpers;
    }

    /**
     * Create config cache instance
     *
     * @param string      $key
     * @param string|null $cacheDir
     *
     * @return SymfonyConfigCache|null
     */
    protected function createConfigCache($key, $cacheDir = null)
    {
        $cacheDir = null === $cacheDir ? $this->cacheDir : $cacheDir;
        $class    = $this->classPrefix . $key;

        return $cacheDir
            ? new SymfonyConfigCache($cacheDir . DIRECTORY_SEPARATOR . $class . '.php', $this->debug)
            : null;
    }

    /**
     * {@inheritDoc}
     *
     * @throws \InvalidArgumentException If cache_dir option not found in options argument
     */
    public function warm($key, array $data, array $options = array())
    {
        if (!isset($options['cache_dir'])) {
            throw new \InvalidArgumentException('cache_dir option not found in options argument');
        }

        $cache = $this->createConfigCache($key, $options['cache_dir']);

        $cache->write($this->dump($key, $data));
    }

    /**
     * Dump data to cache-writable string
     *
     * @param string $key
     * @param array  $data
     *
     * @return string
     *
     * @throws \InvalidArgumentException If no dumper found
     */
    protected function dump($key, array $data)
    {
        if (!array_key_exists($key, $this->dumpers)) {
            throw new \InvalidArgumentException(sprintf('Dumper %s not registered in dumpers', $key));
        }

        $dumper = $this->dumpers[$key];

        return $dumper->dump($data);
    }

    /**
     * {@inheritDoc}
     */
    public function write($key, array $data)
    {
        $cache = $this->createConfigCache($key);

        $cache->write($this->dump($key, $data));
    }

    /**
     * {@inheritDoc}
     */
    public function read($key)
    {
        $cache = $this->createConfigCache($key);

        return null !== $cache && $cache->isFresh() ? include_once $cache : null;
    }
}
