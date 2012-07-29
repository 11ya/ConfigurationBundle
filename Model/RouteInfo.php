<?php
namespace Millwright\ConfigurationBundle\Model;

use Symfony\Component\Routing\Route;

/**
 * Additional parameters from Route
 */
class RouteInfo
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var string
     */
    protected $methodName;

    /**
     * @var array
     */
    protected $acceptedParameters;

    /**
     * @var array
     */
    protected $requiredParameters;

    /**
     * @var array
     */
    protected $variables;

    /**
     * @var MethodInfo|null
     */
    protected $methodInfo;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Routing\Route $route
     * @param MethodInfo|null                  $methodInfo
     */
    public function __construct(Route $route, MethodInfo $methodInfo = null)
    {
        $this->methodInfo = $methodInfo;

        $compiledRoute = $route->compile();
        $tokens        = $compiledRoute->getVariables();
        $defaults      = $route->getDefaults();

        $params = explode('::', $defaults['_controller']);
        unset($defaults['_controller']);

        $this->className          = $params[0];
        $this->methodName         = $params[1];
        $this->acceptedParameters = array_merge(array_keys($defaults), $tokens);
        $this->requiredParameters = array_merge(array_keys($route->getRequirements()), $tokens);
        $this->variables          = $tokens;
    }

    /**
     * Get route controller class name
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Get route action method name
     *
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * Get route accepted params
     *
     * @return array
     */
    public function getAcceptedParameters()
    {
        return $this->acceptedParameters;
    }

    /**
     * Get route required params
     *
     * @return array
     */
    public function getRequiredParameters()
    {
        return $this->requiredParameters;
    }

    /**
     * Get route variables
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Set method info
     *
     * @param MethodInfo $methodInfo
     *
     * @return RouteInfo
     */
    public function setMethodInfo(MethodInfo $methodInfo)
    {
        $this->methodInfo = $methodInfo;

        return $this;
    }

    /**
     * Get route action info
     *
     * @return MethodInfo
     */
    public function getMethodInfo()
    {
        return $this->methodInfo;
    }
}
