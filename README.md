# A simple benchmark tool / framework

## Create your own benchmark

To create your own benchmark, write a class extending AbstractBenchmark. Every public bechmark<Something>() method will be called RUNS times.

See example benchmark class in /benchmarks/ArrayTraversalBenchmark.class.php

## Usage:

    > php run.php BenchmarkName [BenchmarkName]...

### Example:

    > php run.php ArrayTraversal
