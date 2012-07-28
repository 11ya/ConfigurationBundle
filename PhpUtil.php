<?php
namespace Millwright\ConfigurationBundle;

/**
 * PHP hacks and fixes utils
 */
final class PhpUtil
{
    const SHIFT_COUNT = 2;

    /**
     * Smart merge
     *
     * Array_merge rewrite all elements in second level
     * array_merge_recursive adds elements and makes arrays from strings
     *
     * @param array $to
     * @param array $from
     *
     * @return array
     *
     *
     * @example
     * <code>
     *     $this->merge(array(
     *         'level1' => array('param1' => '1', 'params2' => array('a' => 'b'))
     *     ), array(
     *         'level1' => array('param1' => '2', 'params2' => array('a' => 'c', 'd' => 'e'))
     *     ));
     *
     *     //result:
     *     array(
     *         'level1' => array('param1' => '2', 'params2' => array('a' => 'c'), 'd' => 'e')
     *     );
     * </code>
     */
    public static function merge(array $to, array $from)
    {
        foreach ($from as $key => $value) {
            if (!is_array($value)) {
                if (is_int($key)) {
                    $to[] = $value;
                } else {
                    $to[$key] = $value;
                }
            } else {
                if (!isset($to[$key])) {
                    $to[$key] = array();
                }

                $to[$key] = self::merge($to[$key], $value);
            }
        }

        return $to;
    }

    /**
     * Set or modify date time object
     *
     * @param \DateTime|null &$to
     * @param \DateTime|null $from
     *
     * @return \DateTime
     */
    static public function setDateTime(\DateTime &$to = null, \DateTime $from = null)
    {
        if (null === $to) {
            $to = self::cloneObject($from);
        } else {
            $to->setTimestamp($from->getTimestamp());
            $to->setTimezone($from->getTimezone());
        }

        return $to;
    }

    /**
     * Clone object, null-compatible
     *
     * @param object|null &$object
     *
     * @return object|null cloned object or null
     */
    static public function cloneObject(&$object = null)
    {
        return null === $object ? null : clone $object;
    }

    /**
     * Convert model constants to select element options
     *
     * @param string $class       class name with constants
     * @param string $prefix      array values prefix
     * @param string $localPrefix this prefix will be removed from result, if each constants has an TYPE_* like prefix
     * @param string $separator   replace underscores to this separator in constants
     *
     * @return array
     *
     * @example:
     * <code>
     * ex1:
     *
     * class UserRolesEnum {
     *     const ROLE_USER  = 'user';
     *     const ROLE_ADMIN = 'admin';
     * }
     *
     * $array = convertConstantsToOptions('UserRolesEnum');
     *
     * returns:
     * array(
     *     'user' => 'role.user',
     *     'admin'=> 'role.admin',
     * );
     *
     *
     * ex2:
     *
     * interface UserInterface {
     *     const ROLE_USER  = 'user';
     *     const ROLE_ADMIN = 'admin';
     *
     *     const STATUS_ENABLED  = 1;
     *     const STATUS_DISABLED = 0;
     * }
     *
     * $array = convertConstantsToOptions('UserInterface', 'ROLE');
     *
     * returns:
     * array(
     *     'user'  => 'role.user',
     *     'admin' => 'role.admin',
     * );
     *
     * $array = convertConstantsToOptions('UserInterface', 'STATUS');
     *
     * returns:
     * array(
     *     '1' => 'status.enabled',
     *     '0' => 'status.disabled',
     * );
     * </code>
     */
    static public function convertConstantsToOptions($class, $prefix = '', $localPrefix = '', $separator = '.')
    {
        $choices = array();
        if ($localPrefix && !$localPrefix[(strlen($localPrefix) - 1)] != '_') {
            $localPrefix .= '_';
        }

        if (!$prefix) {
            //autodetect prefix from namespace and class name
            $prefixes = explode('\\', trim($class, '\\'));

            for ($i = 0; $i < self::SHIFT_COUNT; $i++) {
                array_shift($prefixes);
            }

            $prefix = implode($separator, $prefixes);
        }

        $prefix .= $separator;

        $reflection = new \ReflectionClass($class);
        foreach ($reflection->getConstants() as $name => $value) {
            if (!$localPrefix || $localPrefix === substr($name, 0, strlen($localPrefix))) {
                $choices[$value] = $prefix . strtolower(
                    str_replace(
                        array($localPrefix, '_'), array('', $separator),
                        $name
                    )
                );
            }
        }

        return $choices;
    }

    /**
     * Assert that constant exist in enum class
     *
     * @param string $class       class name with constants
     * @param string $constant    constant
     * @param string $prefix      array values prefix
     * @param string $separator   replace underscores to this separator
     * @param string $localPrefix constant prefix, ex. STATUS_
     *
     * @throws \InvalidArgumentException If constant not found in enum class
     */
    static public function assertConstant($class, $constant, $prefix = '', $separator = '.', $localPrefix = '')
    {
        $constants = self::convertConstantsToOptions($class, $prefix, $separator, $localPrefix);

        if (!isset($constants[$constant])) {
            throw new \InvalidArgumentException(strtr(
                'Error constant: %const%, see %class%::|%prefix%', array(
                    '%const%'  => $constant,
                    '%class%'  => $class,
                    '%prefix%' => $prefix,
                )
            ));
        }
    }
}