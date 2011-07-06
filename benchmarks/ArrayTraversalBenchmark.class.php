<?php

/**
 * Array traversal benchmark class
 *
 * simple example benchmark class
 *
 * @author Bernd Goldschmidt <github@berndgoldschmidt.de>
 * @copyright 2011 Bernd Goldschmidt <github@berndgoldschmidt.de>
 */
class ArrayTraversalBenchmark extends AbstractBenchmark
{
    /**
     * Number of runs per benchmark method
     *
     * @var integer
     */
    const RUNS = 1000;

    /**
     * Size of array to use
     *
     * @var integer
     */
    const ARRAY_SIZE = 1000;

    /**
     * Minimal value of array content
     *
     * @var integer
     */
    const ARRAY_VALUE_MIN = 0;

    /**
     * Maximum value of array content
     *
     * @var integer
     */
    const ARRAY_VALUE_MAX = 1000;

    /**
     * The array to run benchmarks on
     *
     * @var array of integer of size self::ARRAY_SIZE
     */
    protected $_array = array();

    /**
     * Array object for benchmarks
     *
     * @var ArrayObject
     */
    protected $_arrayObject = null;

    /**
     * Initialize benchmark
     *
     * prepare arrays
     *
     * @return void
     */
    protected function _init()
    {
        $this->_array = array();

        for ($i = 0; $i < self::ARRAY_SIZE; $i++) {
            $this->_array[] = rand(self::ARRAY_VALUE_MIN, self::ARRAY_VALUE_MAX);
        }

        $this->_arrayObject = new ArrayObject($this->_array);
    }

    /**
     * Benchmark method
     * uses while-loop with key() current() next()
     *
     * @return void
     */
    public function benchmarkWhileKeyCurrentNext()
    {
        reset($this->_array);

        while (key($this->_array) !== null) {
            $current = current($this->_array);
            next($this->_array);
        }
    }

    /**
     * Benchmark method
     * uses foreach-loop
     *
     * @return void
     */
    public function benchmarkForeach()
    {
        foreach ($this->_array as $key => $value) {
            $current = $value;
        }
    }
    /**
     * Benchmark method
     * uses for-loop
     *
     * @return void
     */
    public function benchmarkFor()
    {
        for ($i = 0; $i < count($this->_array); $i++) {
            $current = $this->_array[$i];
        }
    }

    /**
     * Benchmark method
     * uses Iterator of ArrayObject
     *
     * @return void
     */
    public function benchmarkArrayObjectIterator()
    {
        $this->_arrayObject = new ArrayObject($this->_array);

        $iterator = $this->_arrayObject->getIterator();

        while ($iterator->valid()) {
            $current = $iterator->current();
            $iterator->next();
        }
    }
}