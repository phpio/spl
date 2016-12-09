<?php
/**
 * (c) phpio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpio\Spl;

/**
 * @property array $properties
 */
trait WithPropertiesTrait
{
    /**
     * @param array $properties
     *
     * @throws \UnexpectedValueException
     */
    public function __construct(array $properties = null)
    {
        if ($properties !== null) {
            $diff = array_diff(array_keys($properties), array_keys($this->properties));
            if ($diff) {
                throw new \UnexpectedValueException(implode(', ', $diff));
            }
            $this->properties = array_merge($this->properties, $properties);
        }
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __get($name)
    {
        if (!isset($this->properties[$name]) && !array_key_exists($name, $this->properties)) {
            throw new \InvalidArgumentException($name);
        }
        return $this->properties[$name];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->properties[$name]) && !empty($this->properties[$name]);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws \InvalidArgumentException
     */
    public function __set($name, $value)
    {
        if (!isset($this->properties[$name]) && !array_key_exists($name, $this->properties)) {
            throw new \InvalidArgumentException($name);
        }
        $this->properties[$name] = $value;
    }

    /**
     * @param string $name
     */
    public function __unset($name)
    {
        if (isset($this->properties[$name]) || array_key_exists($name, $this->properties)) {
            $this->properties[$name] = null;
        }
    }
}