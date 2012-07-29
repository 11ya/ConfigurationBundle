<?php
namespace Millwright\ConfigurationBundle\Configuration;

use Millwright\ConfigurationBundle\Model\RouteInfo;
use Millwright\ConfigurationBundle\Model\MethodInfo;

/**
 * Option builder helper interface
 */
interface ConfigurationHelperInterface
{
    /**
     * Get some route parameters and annotations by route name
     *
     * @param  string $name route name
     *
     * @return RouteInfo
     */
    function getRouteInfo($name);

    /**
     * Grab and merge method and class annotations
     *
     * @param string $className  class name
     * @param string $methodName method name
     * @param string $configName configuration key name for merge with method and class annotations
     *
     * @return MethodInfo
     */
    function getMethodInfo($className, $methodName, $configName);
}
