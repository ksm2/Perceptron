<?php

namespace CherryPick\Component\Perceptron;

/**
 * @package CherryPick\Component\Perceptron
 * @author moellers
 */
interface PerceptronInterface
{

    /**
     * Tests the perceptron by given input data
     * and an output data container.
     *
     * @param mixed $input
     * @param mixed &$output
     * @return mixed
     */
    public function test($input, $output = array());

    /**
     * Trains all perceptron weights by given input data
     * and expected outputs.
     *
     * @param mixed $input
     * @param mixed $expectedOutput
     * @return $this
     */
    public function train($input, $expectedOutput);

    /**
     * Initializes all perceptron weights with values.
     *
     * @return $this
     */
    public function initialize();

    /**
     * Returns the weight between two nodes.
     *
     * @param Node $from
     * @param Node $to
     * @return null|float
     */
    public function getWeight(Node $from, Node $to);

    /**
     * Sets the weight between two nodes.
     *
     * @param Node $from
     * @param Node $to
     * @param int $value
     * @return $this
     */
    public function setWeight(Node $from, Node $to, $value);

    /**
     * Returns the outgoing weights from a node.
     *
     * @param Node $from
     * @return float[]
     */
    public function getOutgoingWeights(Node $from);

    /**
     * Returns the incoming weights from a node.
     *
     * @param Node $to
     * @return float[]
     */
    public function getIncomingWeights(Node $to);

    /**
     * Returns all perceptron layers.
     *
     * @return LayerInterface[]
     */
    public function getLayers();

    /**
     * Returns the set bias.
     *
     * @return float
     */
    public function getBias();
}
