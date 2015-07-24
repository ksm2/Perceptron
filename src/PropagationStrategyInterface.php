<?php

namespace CherryPick\Component\Perceptron;

/**
 * @package CherryPick\Component\Perceptron
 * @author moellers
 */
interface PropagationStrategyInterface
{

    /**
     * Calculates a node's value based on the layer in front of it.
     *
     * @param PerceptronInterface $perceptron The perceptron in which we calculate.
     * @param Node $subject The subjected node which value gets recalculated.
     * @param LayerInterface $inFront The layer connected in front of the subject.
     * @return float The new subject value.
     */
    public function calculateValue(PerceptronInterface $perceptron, Node $subject, LayerInterface $inFront);

    /**
     * Calculates a hidden node's delta based on the layer behind it.
     *
     * @param PerceptronInterface $perceptron The perceptron in which we calculate.
     * @param Node $subject The subjected node which weight gets recalculated.
     * @param LayerInterface $behind The layer connected behind the subject.
     * @return float The delta for the subject.
     */
    public function calculateHiddenDelta(PerceptronInterface $perceptron, Node $subject, LayerInterface $behind);

    /**
     * Calculates an output node's delta based on the layer behind it.
     *
     * @param PerceptronInterface $perceptron The perceptron in which we calculate.
     * @param Node $subject The subjected node which weight gets recalculated.
     * @param float $expectedValue The expected value.
     * @return float The delta for the subject.
     */
    public function calculateOutputDelta(PerceptronInterface $perceptron, Node $subject, $expectedValue);
}
