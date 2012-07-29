<?php
namespace Millwright\ConfigurationBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Millwright\ConfigurationBundle\Builder\OptionManagerInterface;

/**
 * Configuration cache warmer
 */
class ConfigurationCacheWarmer implements CacheWarmerInterface
{
    protected $optionManager;

    /**
     * Constructor
     *
     * @param OptionManagerInterface $optionManager
     */
    public function __construct(OptionManagerInterface $optionManager)
    {
        $this->optionManager = $optionManager;
    }

    /**
     * Warms up the cache
     *
     * @param string $cacheDir the cache directory
     */
    public function warmUp($cacheDir)
    {
        $this->optionManager->warmUp(array('cache_dir' => $cacheDir));
    }

    /**
     * Checks whether this warmer is optional or not
     *
     * @return Boolean always true
     */
    public function isOptional()
    {
        return true;
    }
}
