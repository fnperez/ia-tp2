<?php

declare(strict_types=1);

namespace IaTp2;

use PW\GA\Chromosome;
use PW\GA\ChromosomeGeneratorInterface;
use PW\GA\Config;
use PW\GA\CrossoverMethod\OnePointCrossover;
use PW\GA\FitnessCalculatorInterface;
use PW\GA\GeneticAlgorithm;
use PW\GA\MutateMethod\GeneSwap;
use PW\GA\SuccessCriteriaInterface;

class Exercise implements FitnessCalculatorInterface, SuccessCriteriaInterface, ChromosomeGeneratorInterface
{
    private array $rules;
    private int $participants;
    private int $tests;

    public function __construct(int $participants, int $tests, array $rules)
    {
        $this->participants = $participants;
        $this->rules = $rules;
        $this->tests = $tests;
    }

    public function findSolution($options, $iterations)
    {
        $options = array_merge([
            Config::SORT_DIR => GeneticAlgorithm::SORT_DIR_DESC,
        ], $options);

        $gaEngine = new GeneticAlgorithm(
            $this,
            new OnePointCrossover,
            new GeneSwap,
            new Config($options)
        );

        $gaEngine
            ->initPopulation($this)
            ->optimiseUntil($this, $iterations);

        $results = $gaEngine->getFittest()->getValue();

        return array_chunk($results, $this->tests);
    }

    public function calculateFitness(array $results)
    {
        $tests = array_chunk($results, $this->tests);
        $fitness = 0;
        foreach ($this->rules as $index => $rule) {
            $fitness += $rule($tests) ? 0 : -1;
        }

        return $fitness;
    }

    public function validateSuccess(Chromosome $solution)
    {
        return $solution->getFitness($this) === 0;
    }

    public function generateChromosomes($numberOfChromosomes)
    {
        $chromosomes = [];
        for ($i = 0; $i <= $numberOfChromosomes; $i++) {
            $results = [];
            for ($j = 0; $j < $this->participants * $this->tests; $j++) {
                $results[] = mt_rand(0, 10);
            }

            $chromosomes[] = new Chromosome($results);
        }

        return $chromosomes;
    }
}
