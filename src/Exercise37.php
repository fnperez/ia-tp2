<?php

declare(strict_types=1);

namespace IaTp2;

class Exercise37
{
    static function generate()
    {
        /*
            0. Erica
            1. Noemi
            2. Daniela
            3. Marcia
            4. Vilma
            ---------------
            0. Primer Test
            1. Segundo Test
            2. Tercer Test

            DATA EXTRA:
                Las notas de la primera prueba fueron, 3, 4, 5, 7 y 9.
                Las notas de la segunda prueba fueron, 4, 6, 7, 9 y 10.
                Las notas de la tercer prueba fueron, 5, 7, 8, 9 y 10.

         */

        $rules = [
            fn(array $results) => empty(array_filter($results, fn($tests) => !in_array($tests[0], [3, 4, 5, 7, 9]))),
            fn(array $results) => empty(array_filter($results, fn($tests) => !in_array($tests[1], [4, 6, 7, 9, 10]))),
            fn(array $results) => empty(array_filter($results, fn($tests) => !in_array($tests[2], [5, 7, 8, 9, 10]))),
            fn(array $results) => $results[0][0] === 7,  // Erica obtuvo 7 en la primer prueba
            fn(array $results) => $results[0][2] > 7, // Erica obtuvo más de 7 en la tercer prueba
            fn(array $results) => $results[1][1] === 10, // Noemi saco 10 en la segunda prueba
            fn(array $results) => array_sum($results[1]) === 22, // Noemi sumó 22 entre las tres pruebas.
            fn(array $results) => $results[2][0] === 4, // Daniela obtuvo un 4 en la primer prueba
            fn(array $results) => $results[1][0] > $results[2][0], // Noemi superó a Daniela en la primera prueba.
            fn(array $results) => $results[3][0] > $results[3][1] && $results[3][0] > $results[3][2], // Marcia obtuvo su mejor puntaje en la primera prueba.
            fn(array $results) => $results[0][2] !== 8, // Erica no obtuvo 8 en la tercera prueba
            fn(array $results) => empty(array_filter($results, fn($tests) => $tests[1] === 7 && $tests[2] === 8)), // La que se sacó 7 en la segunda prueba no se sacó 8 en la tercera prueba
            fn(array $results) => $results[1][2] - $results[3][2] === 2, // En la tercera prueba Noemi sacó 2 puntos más que marcia
            fn(array $results) => array_sum($results[4]) - $results[4][0] === 19, // Vilma obtuvo 19 puntos entre las dos últimas pruebas
            fn(array $results) => empty(array_filter($results, fn($tests) => $tests[1] === 4 && $tests[2] === 8)), // La que menos nota sacó en la segunda prueba no fue la que logró un 8 en la tercera.
        ];

        return new Exercise(5, 3, $rules);
    }
}
