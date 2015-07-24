<?php

namespace CherryPick\Component\Perceptron;

/**
 * @package CherryPick\Component\Perceptron
 * @author moellers
 */
final class PerceptronUtil
{

    /**
     * Not instantiable.
     */
    private function __construct() {}

    /**
     * Calculates the dot product over two vectors.
     *
     * @param float[] $vec1
     * @param float[] $vec2
     * @return float
     */
    public static function dot(array $vec1, array $vec2)
    {
        return array_sum(array_map(
            function ($a, $b) {
                return $a * $b;
            },
            $vec1,
            $vec2
        ));
    }

    /**
     * Calculates the sigmoid activation function.
     *
     * @param float $z
     * @return float
     */
    public static function sigmoid($z)
    {
        return 1 / (1 + exp(-$z));
    }
}
