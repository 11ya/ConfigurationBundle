<?php
namespace Millwright\ConfigurationBundle\Builder;

use Symfony\Component\Config\ConfigCache;

use Millwright\ConfigurationBundle\Cache\CacheAdapterInterface;

/**
 * Options manager
 */
class OptionManager implements OptionManagerInterface
{
    protected $cache;
    protected $optionBuilders;

    /**
     * Constructor
     *
     * @param CacheAdapterInterface    $cache
     * @param OptionBuilderInterface[] $optionBuilders
     */
    public function __construct(CacheAdapterInterface $cache, array $optionBuilders)
    {
        $this->cache          = $cache;
        $this->optionBuilders = $optionBuilders;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions($key)
    {
        $builder = $this->getBuilder($key);
        if ($builder->isCacheable()) {
            $data = $this->cache->read($key, $success);
            if (!$success) {
                $data = $builder->build();
                $this->cache->write($key, $data);
            }
        } else {
            $data = $builder->build();
        }

        return $data;
    }

    /**
     * Get builder adapter
     *
     * @param string $key
     *
     * @return OptionBuilderInterface
     *
     * @throws \InvalidArgumentException If builder not found in option builders
     */
    protected function getBuilder($key)
    {
        if (!array_key_exists($key, $this->optionBuilders)) {
            throw new \InvalidArgumentException(sprintf('%s builder not registered in option builders', $key));
        }

        return $this->optionBuilders[$key];
    }

    /**
     * {@inheritDoc}
     */
    public function warmUp(array $options)
    {
        foreach ($this->optionBuilders as $key => $builder) {
            $this->buildedOptions[$key] = $builder->build();
            $this->cache->warm($key, $this->buildedOptions[$key], $options);
        }
    }
}
