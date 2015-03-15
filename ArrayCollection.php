<?php

namespace Kasseler\Component\Collections;

use ArrayIterator;
use Closure;

class ArrayCollection implements CollectionInterface
{
    private $elements;

    /**
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->elements;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return reset($this->elements);
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return end($this->elements);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->elements);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function remove($key)
    {
        if (!isset($this->elements[$key]) && ! array_key_exists($key, $this->elements)) {
            return null;
        }

        $removed = $this->elements[$key];
        unset($this->elements[$key]);

        return $removed;
    }

    /**
     * @param $element
     *
     * @return bool
     */
    public function removeElement($element)
    {
        $key = array_search($element, $this->elements, true);
        if ($key === false) {
            return false;
        }

        unset($this->elements[$key]);

        return true;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @return ArrayCollection
     */
    public function offsetSet($offset, $value)
    {
        if (!isset($offset)) {
            return $this->add($value);
        }

        return $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function containsKey($key)
    {
        return isset($this->elements[$key]) || array_key_exists($key, $this->elements);
    }

    /**
     * @param $element
     *
     * @return bool
     */
    public function contains($element)
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function exists($key)
    {
        return $this->containsKey($key);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        $keys = is_array($key) ? $key : func_get_args();
        foreach ($keys as $key) {
            if ($this->exists($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $element
     *
     * @return mixed
     */
    public function indexOf($element)
    {
        return array_search($element, $this->elements, true);
    }

    /**
     * @param null $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        if ($key){
            return isset($this->elements[$key]) ? $this->elements[$key] : $default;
        }

        return $this->elements;
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function replace(array $attributes)
    {
        return array_merge($this->elements, $attributes);
    }

    /**
     * @param array $filter
     *
     * @return array
     */
    public function getKeys($filter = [])
    {
        return empty($filter) ? array_keys($this->elements) : array_intersect_key($this->elements, $filter);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return array_values($this->elements);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return ArrayCollection
     */
    public function set($key, $value)
    {
        if (is_null($key)) {
            $this->elements[] = $value;
        } else {
            $this->elements[$key] = $value;
        }

        return $this;
    }

    /**
     * @param $value
     *
     * @return ArrayCollection
     */
    public function add($value)
    {
        $this->elements[] = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->elements);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * @param callable $func
     *
     * @return static
     */
    public function map(Closure $func)
    {
        return new static(array_map($func, $this->elements));
    }

    /**
     * @param callable $p
     *
     * @return static
     */
    public function filter(Closure $p)
    {
        return new static(array_filter($this->elements, $p));
    }

    /**
     * @return ArrayCollection
     */
    public function clear()
    {
        $this->elements = [];

        return $this;
    }

    /**
     * @param      $offset
     * @param      $length
     *
     * @return array
     */
    public function slice($offset, $length = null)
    {
        return array_slice($this->elements, $offset, $length, true);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return serialize($this->elements);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function __get($key) {
        return $this->get($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value) {
        $this->set($key, $value);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function __isset($key) {
        return $this->exists($key);
    }

    /**
     * @param $key
     */
    public function __unset($key) {
        $this->remove($key);
    }
}
