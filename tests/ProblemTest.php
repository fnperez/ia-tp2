<?php

declare(strict_types=1);

namespace Tests;

use Analog\Analog;
use Analog\Handler\EchoConsole;
use IaTp2\Exercise37;
use PHPUnit\Framework\TestCase;

class ProblemTest extends TestCase
{
    public function setUp(): void
    {
        Analog::handler(EchoConsole::init());
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
         ANSWER:
            0. Erica: 7, 4, 9,
            1. Noemi: 5, 10, 7,
            2. Daniela: 4, 6, 8,
            3. Marcia: 9, 7, 5,
            4. Vilma: 3, 9, 10,
         */
        list($erica, $noemi, $daniela, $marcia, $vilma) = $exercise->findSolution([
            \PW\GA\Config::WEIGHTING_COEF => 0.6,
            \PW\GA\Config::POPULATION_COUNT => 500,
            \PW\GA\Config::CHURN_ENTROPY => 0.5,
            \PW\GA\Config::MUTATE_ENTROPY => 0.5,
        ], 5000);

        $this->assertEquals(0, $exercise->calculateFitness([
            ...$erica,
            ...$noemi,
            ...$daniela,
            ...$marcia,
            ...$vilma
        ]));

        $this->assertEquals([7, 4, 9], $erica);
        $this->assertEquals([5, 10, 7], $noemi);
        $this->assertEquals([4, 6, 8], $daniela);
        $this->assertEquals([9, 7, 5], $marcia);
        $this->assertEquals([3, 9, 10], $vilma);
    }
}
