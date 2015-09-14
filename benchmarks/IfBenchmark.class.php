<?php

/**
 * If benchmark class
 *
 * simple example benchmark class
 *
 * @author Bernd Goldschmidt <github@berndgoldschmidt.de>
 * @copyright 2015 Bernd Goldschmidt <github@berndgoldschmidt.de>
 */
class IfBenchmark extends AbstractBenchmark
{
    /**
     * Number of runs per benchmark method
     *
     * @var integer
     */
    const RUNS = 10000;

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
    }

    /**
     * Benchmark method
     * uses if ... else if ...
     *
     * @return void
     */
    public function benchmarkIfElseIf()
    {
        $pivotValue = floor((self::ARRAY_VALUE_MIN + self::ARRAY_VALUE_MAX) / 2);
        
        $countLess = 0;
        $countEqual = 0;
        $countGreater = 0;
        
        foreach ($this->_array as $value) {
            
            if ($value === $pivotValue) {
                $countEqual++;
            } else if ($value < $pivotValue) {
                $countLess++;
            } else if ($value > $pivotValue) {
                $countGreater++;
            }
            
        }
    }

    /**
     * Benchmark method
     * uses if ... elseif ...
     *
     * @return void
     */
    public function benchmarkElseif()
    {
        $pivotValue = floor((self::ARRAY_VALUE_MIN + self::ARRAY_VALUE_MAX) / 2);
        
        $countLess = 0;
        $countEqual = 0;
        $countGreater = 0;
        
        foreach ($this->_array as $value) {
            
            if ($value === $pivotValue) {
                $countEqual++;
            } elseif ($value < $pivotValue) {
                $countLess++;
            } elseif ($value > $pivotValue) {
                $countGreater++;
            }
            
        }
    }
}