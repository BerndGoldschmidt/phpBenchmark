<?php

/**
 * Minimal run script for phpBenchmark
 *
 * @author Bernd Goldschmidt <github@berndgoldschmidt.de>
 * @copyright 2011 Bernd Goldschmidt <github@berndgoldschmidt.de>
 */

// path of this script
$path = rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

// inculde the base classes
require_once $path . 'classes/Benchmark.class.php';
require_once $path . 'classes/AbstractBenchmark.class.php';

// if no benchmark is select print short usage hint
if ($argc < 2) {
    Benchmark::printUsage();
    exit;
}

// run all benchmarks
for ($i = 1; $i < $argc; $i++) {
    $benchmarkName = $argv[$i];
    Benchmark::run($benchmarkName, $path . 'benchmarks' . DIRECTORY_SEPARATOR);
}


