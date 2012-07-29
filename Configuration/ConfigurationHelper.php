<?php
namespace Millwright\ConfigurationBundle\Configuration;

use Symfony\Component\Routing\RouterInterface;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Routing\Route;

use Millwright\ConfigurationBundle\Configuration\MethodInfo;
use Millwright\ConfigurationBundle\Configuration\RouteInfo;

/**
 * Option builder base class
 */
class ConfigurationHelper implements ConfigurationHelperInterface
{
    protected $router;
    protected $reader;

    /**
     * Constructor
     *
     * @param RouterInterface $router
     * @param Reader          $reader
     */
    public function __construct(RouterInterface $router, Reader $reader)
    {
        $this->router = $router;
        $this->reader = $reader;
    }

    protected function getConfigurations(array $annotations)
    {
        $configurations = array();
        foreach ($annotations as $configuration) {
            $key                    = get_class($configuration);
            $configurations[$key][] = $configuration;
        }

        return $configurations;
    }

    protected function getMethodInfoByReflection(\ReflectionMethod $method, $key)
    {
        $classConfigurations  = $this->getConfigurations(
            $this->reader->getClassAnnotations($method->getDeclaringClass())
        );
        $methodConfigurations = $this->getConfigurations($this->reader->getMethodAnnotations($method));

        $class = $method->getDeclaringClass()->getName();
        $name  = $method->getName();

        $key = $key ? $key : ($class . $name);

        $configData = isset($this->config[$key])
            ? $this->config[$key]
            : array();

        $annotations = array_merge($classConfigurations, $methodConfigurations, $configData);

        $arguments = array();
        foreach ($method->getParameters() as $argument) {
            $arguments[$argument->getName()] = $argument;
        }

        return new MethodInfo($arguments, $annotations);
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodInfo($className, $methodName, $configName)
    {
        $class  = new \ReflectionClass($className);
        $method = $class->getMethod($methodName);

        return $this->getMethodInfoByReflection($method, $configName);
    }

    /**
     * {@inheritDoc}
     */
    public function getRouteInfo($name)
    {
        $route = $this->router->getRouteCollection()->get($name);
        if (!$route) {
            return null;
        }

        $routeInfo  = new RouteInfo($route);
        $methodInfo = $this->getMethodInfo($routeInfo->getClassName(), $routeInfo->getMethodName(), $name);

        $routeInfo->setMethodInfo($methodInfo);

        return $routeInfo;
    }
}
