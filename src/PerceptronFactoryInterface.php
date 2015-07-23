<?php

namespace CherryPick\Component\Perceptron;

use CherryPick\Component\Perceptron\Exception\PerceptronConfigurationException;

/**
 * @package CherryPick\Component\Perceptron
 * @author moellers
 */
interface PerceptronFactoryInterface
{

    /**
     * Sets the input parameters of the perceptron.
     *
     * @param array $arrayOfLabels An array of strings.
     * @return $this
     */
    public function setInputs(array $arrayOfLabels);

    /**
     * Sets the output values of the perceptron.
     *
     * @param array $arrayOfLabels An array of strings.
     * @return $this
     */
    public function setOutputs(array $arrayOfLabels);

    /**
     * Sets the perceptron bias which influences the
     * forward propagation.
     *
     * @param float $bias
     * @return $this
     */
    public function setBias($bias);

    /**
     * Sets the learning rate which influences how
     * much an error influences the deltas of weights.
     *
     * @param float $learningRate
     * @return $this
     */
    public function setLearningRate($learningRate);

    /**
     * Sets the strategy which defines the way a propagation
     * gets calculated.
     *
     * @param PropagationStrategyInterface $propagationStrategy
     * @return $this
     */
    public function setPropagationStrategy(PropagationStrategyInterface $propagationStrategy);

    /**
     * Adds an hidden layer to the perceptron.
     *
     *
     * @param int $numberOfNodes Bigger than zero.
     * @return $this
     * @throws PerceptronConfigurationException
     */
    public function addHiddenLayer($numberOfNodes);

    /**
     * Removes an hidden layer.
     *
     * @param $index
     * @return $this
     */
    public function removeHiddenLayer($index);

    /**
     * Creates a perceptron based on the factory configuration.
     *
     * If the factory configuration is invalid, an exception
     * will be thrown with error details.
     *
     * @return PerceptronInterface
     * @throws PerceptronConfigurationException
     */
    public function createPerceptron();
}
