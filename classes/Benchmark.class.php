<?php

/**
 * Benchmark class prepares, runs and displays results of benchmarks
 *
 * @author Bernd Goldschmidt <github@berndgoldschmidt.de>
 * @copyright 2011 Bernd Goldschmidt <github@berndgoldschmidt.de>
 */
class Benchmark
{
    /**
     * RUNS key for results array
     *
     * @var string
     */
    const RUNS = 'runs';

    /**
     * TIME_TOTAL key for results array
     *
     * @var string
     */
    const TIME_TOTAL = 'total';

    /**
     * TIME_AVERAGE key for results array
     *
     * @var string
     */
    const TIME_AVERAGE = 'average';

    /**
     * local storage for benchmark results
     *
     * @var array hash of className => methodName => results
     */
    protected static $_results = array();

    /**
     * Run benchmark
     *
     * @param string $benchmarkName Name of benchmark
     * @param string $benchmarkPath Path of benchmark class files
     * @return void
     * @throws Exception
     */
    public static function run($benchmarkName, $benchmarkPath = null)
    {
        $benchmark = self::_getClass($benchmarkName, $benchmarkPath);

        if (!($benchmark instanceof AbstractBenchmark)) {
            throw new Exception('Every benchmark must inherit from AbstractBenchmark');
        }

        $benchmarkMethodNames = self::_getBenchmarkMethodNames($benchmark);

        foreach ($benchmarkMethodNames as $methodName) {
            self::_runBenchmark($benchmark, $methodName);
        }

        echo self::_renderResults();
    }

    /**
     * Creates and returnd benchmark class of given name
     *
     * @param string $benchmarkName Name of benchmark
     * @param string $benchmarkPath Path of benchmark class file
     * @return AbstractBenchmark
     */
    protected static function _getClass($benchmarkName, $benchmarkPath = null)
    {
        if (preg_match('/Benchmark$/', $benchmarkName, $matches)) {
            $benchmarkName = substr($benchmarkName, 0, -1 * strlen('Benchmark'));
        }

        if ($benchmarkPath === null) {
            $benchmarkPath = getcwd() . './benchmarks/';
        }

        require_once $benchmarkPath . $benchmarkName . 'Benchmark.class.php';

        $className = $benchmarkName . 'Benchmark';
        $benchmark = new $className;

        return $benchmark;
    }

    /**
     * Returns all benchmark Methods of given AbstractBenchmark inherited object
     *
     * @param AbstractBenchmark $benchmark
     * @return array of string the method names
     */
    protected static function _getBenchmarkMethodNames(AbstractBenchmark $benchmark)
    {
        $reflection = new ReflectionClass($benchmark);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $benchmarkMethodNames = array();

        foreach ($methods as $method) {
            if (preg_match('/^benchmark/', $method->getName())) {
                $benchmarkMethodNames[] = $method->getName();
            }
        }

        return $benchmarkMethodNames;
    }

    /**
     * Runs a single benchmark method in an AbstractBenchmark inherited object
     * number of method calls is determined by RUNS constant in given object
     *
     * @param AbstractBenchmark $benchmark
     * @param string $methodName
     * @return void
     */
    protected static function _runBenchmark(AbstractBenchmark $benchmark, $methodName)
    {
        $startTime = microtime(true);

        for ($i = 0; $i < $benchmark::RUNS; $i++) {
            $benchmark->$methodName();
        }

        $endTime = microtime(true);

        $usedTime = $endTime - $startTime;

        self::_addResult($benchmark, $methodName, $usedTime);
    }

    /**
     * Adds benchmark result to results
     *
     * @param AbstractBenchmark $benchmark
     * @param string $methodName
     * @param float $usedTime the time used for the benchmark runs
     * @return void
     */
    protected static function _addResult(AbstractBenchmark $benchmark, $methodName, $usedTime)
    {
        if (!isset (self::$_results[get_class($benchmark)])) {
            self::$_results[get_class($benchmark)] = array();
        }

        if (!isset (self::$_results[get_class($benchmark)][$methodName])) {
            self::$_results[get_class($benchmark)][$methodName] = array();
        }

        self::$_results[get_class($benchmark)][$methodName][self::TIME_TOTAL] = $usedTime;
        self::$_results[get_class($benchmark)][$methodName][self::TIME_AVERAGE] = $usedTime / $benchmark::RUNS;
        self::$_results[get_class($benchmark)][$methodName][self::RUNS] = $benchmark::RUNS;
    }

    /**
     * Quick rendering of results
     *
     * @return string
     */
    protected static function _renderResults()
    {
        $output = '';

        foreach (self::$_results as $className => $methodNames) {

            $output .= 'Benchmark result for ' . $className . "\n";
            $output .= '-------------------------------------------------------- ' . "\n";

            foreach ($methodNames as $methodName => $results) {

                $methodName = preg_replace('/^benchmark/', '', $methodName);

                $output .= $results[self::RUNS] . ' runs of ' . $methodName . ":\n";
                $output .= ' > Total time taken:             ' . $results[self::TIME_TOTAL] . "\n";
                $output .= ' > Average time taken per run:   ' . $results[self::TIME_AVERAGE] . "\n";
                $output .= "\n";
            }

            $output .= '-------------------------------------------------------- ' . "\n";
            $output .= "\n\n";
        }

        return $output;

    }

    /**
     * Print short information about the tools usage
     *
     * @return void
     */
    public static function printUsage()
    {
        $s = "phpBenchmark\n"
           . "Usage: php run.php BenchmarkName [BenchmarkName]...\n"
           . "\n"
           . "Example: php run.php ArrayTraversal\n"
           . "\n";

        echo $s;
    }
}