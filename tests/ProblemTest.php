<?php

declare(strict_types=1);

namespace Tests;

use Analog\Analog;
use Analog\Handler\EchoConsole;
use GeneticAlgorithm\Configuration;
use GeneticAlgorithm\CrossingMethods\SimpleCrossingMethod;
use GeneticAlgorithm\GeneticAlgorithm;
use GeneticAlgorithm\MutationMethods\SimpleMutationMethod;
use GeneticAlgorithm\SelectionMethods\Ranking;
use GeneticAlgorithm\SelectionMethods\Tournament;
use GeneticAlgorithm\StopMethods\MinimumAptitude;
use IaTp2\Exercise;
use IaTp2\Exercise37;
use PHPUnit\Framework\TestCase;

class ProblemTest extends TestCase
{
    public function setUp(): void
    {
        Analog::handler(EchoConsole::init());
    }

    public function _testRules()
    {
        Analog::debug(str_pad('', 100, '-'));
        $exercise = Exercise37::generateSolved();

        $this->assertEquals(0, $exercise->getAptitude());
    }

    public function _testAlgoResolution()
    {
        $algo = new GeneticAlgorithm(
            new Configuration(
                new MinimumAptitude(-5),
                new Ranking(200),
                new SimpleCrossingMethod,
                new SimpleMutationMethod(0.6),
                1000
            ),
            Exercise37::class
        );

        $exercise = $algo->execute();

        $population = $exercise->getPopulation();

        foreach ($population as $participant) {
            $results = implode(',', $participant->getResults());
            Analog::debug("{$participant->getName()} | RESULTS: {$results} | APTITUDE: {$participant->getAptitude($population)}");
        }
    }

    public function testRules()
    {
        $exercise = Exercise37::generate();

        /*
         * ANSWER:
            0. Erica: 7, 4, 9,
            1. Noemi: 5, 10, 7,
            2. Daniela: 4, 6, 8,
            3. Marcia: 9, 7, 5,
            4. Vilma: 3, 9, 10,
         */
        $answer = [
            7, 4, 9,
            5, 10, 7,
            4, 6, 8,
            9, 7, 5,
            3, 9, 10,
        ];

        $this->assertEquals(0, $exercise->calculateFitness($answer));
    }

    public function testSolution()
    {
        $exercise = Exercise37::generate();

        /*
         * ANSWER:
            0. Erica: 7, 4, 9,
            1. Noemi: 5, 10, 7,
            2. Daniela: 4, 6, 8,
            3. Marcia: 9, 7, 5,
            4. Vilma: 3, 9, 10,
         */
        list($erica, $noemi, $daniela, $marcia, $vilma) = $exercise->findSolution([
            \PW\GA\Config::WEIGHTING_COEF => 0.4,
            \PW\GA\Config::POPULATION_COUNT => 500,
            \PW\GA\Config::CHURN_ENTROPY => 0.8,
            \PW\GA\Config::MUTATE_ENTROPY => 0.8,
        ], 2000);

        $this->assertEquals(0, $exercise->calculateFitness([
            ...$erica,
            ...$noemi,
            ...$daniela,
            ...$marcia,
            ...$vilma
        ]));
//        $this->assertEquals([7, 4, 9], $erica);
//        $this->assertEquals([5, 10, 7], $noemi);
//        $this->assertEquals([4, 6, 8], $daniela);
//        $this->assertEquals([9, 7, 5], $marcia);
//        $this->assertEquals([3, 9, 10], $vilma);
    }
}
