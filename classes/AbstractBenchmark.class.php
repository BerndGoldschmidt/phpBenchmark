<?php

/**
 * Abstract base class for all benchark classes
 *
 * @author Bernd Goldschmidt <github@berndgoldschmidt.de>
 * @copyright 2011 Bernd Goldschmidt <github@berndgoldschmidt.de>
 */
abstract class AbstractBenchmark
{
    /**
     * Number of runs for each benchmark method
     *
     * overwrite this constant in derived classes
     *
     * @var integer
     */
    const RUNS = 1;

    /**
     * Constructor
     *
     * if overwritten in derived classes make sure to call this parent::__constructor()
     * or call the _init() method within own constructor
     *
     * @return void
     */
    public function __construct() {
        $this->_init();
    }

    /**
     * Initialize benchmark class
     *
     * Impement this method to prepare your benchmark object
     *
     * @return void
     */
    abstract protected function _init();
}