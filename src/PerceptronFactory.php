<?php

namespace CherryPick\Component\Perceptron;

use CherryPick\Component\Perceptron\Exception\PerceptronConfigurationException;

/**
 * @package CherryPick\Component\Perceptron
 * @author moellers
 */
class PerceptronFactory implements PerceptronFactoryInterface
{

    private $inputs = array();

    private $outputs = array();

    private $bias = 0.0;

    private $learningRate = 0.2;

    private $propagationStrategy;

    private $hiddenLayers = array();

    /**
     * PerceptronFactory constructor.
     */
    final public function __construct()
    {
        $this->propagationStrategy = new SigmoidPropagationStrategy();
    }

    /**
     * Sets the input parameters of the perceptron.
     *
     * @param array $arrayOfLabels An array of strings.
     * @return $this
     */
    public function setInputs(array $arrayOfLabels)
    {
        $this->inputs = $arrayOfLabels;
        return $this;
    }

    /**
     * Sets the output values of the perceptron.
     *
     * @param array $arrayOfLabels An array of strings.
     * @return $this
     */
    public function setOutputs(array $arrayOfLabels)
    {
        $this->outputs = $arrayOfLabels;
        return $this;
    }

    /**
     * Sets the perceptron bias which influences the
     * forward propagation.
     *
     * @param float $bias
     * @return $this
     */
    public function setBias($bias)
    {
        $this->bias = $bias;
        return $this;
    }

    /**
     * Sets the learning rate which influences how
     * much an error influences the deltas of weights.
     *
     * @param float $learningRate
     * @return $this
     */
    public function setLearningRate($learningRate)
    {
        $this->learningRate = $learningRate;
        return $this;
    }

    /**
     * Sets the strategy which defines the way a propagation
     * gets calculated.
     *
     * @param PropagationStrategyInterface $propagationStrategy
     * @return $this
     */
    public function setPropagationStrategy(PropagationStrategyInterface $propagationStrategy)
    {
        $this->propagationStrategy = $propagationStrategy;
        return $this;
    }

    /**
     * Adds an hidden layer to the perceptron.
     *
     *
     * @param int $numberOfNodes Bigger than zero.
     * @return $this
     * @throws PerceptronConfigurationException
     */
    public function addHiddenLayer($numberOfNodes)
    {
        if (!is_int($numberOfNodes)) {
            throw new PerceptronConfigurationException('Number of nodes of a hidden layer must be an int');
        }

        if ($numberOfNodes < 1) {
            throw new PerceptronConfigurationException('There must be at least one node in a hidden layer');
        }

        $this->hiddenLayers[] = $numberOfNodes;
        return $this;
    }

    /**
     * Removes an hidden layer.
     *
     * @param $index
     * @return $this
     */
    public function removeHiddenLayer($index)
    {
        array_splice($this->hiddenLayers, $index, 1);
        return $this;
    }

    /**
     * Creates a perceptron based on the factory configuration.
     *
     * If the factory configuration is invalid, an exception
     * will be thrown with error details.
     *
     * @return PerceptronInterface
     * @throws PerceptronConfigurationException
     */
    public function createPerceptron()
    {
        if (empty($this->inputs)) {
            throw new PerceptronConfigurationException('You have to specify at least one input');
        }

        if (empty($this->outputs)) {
            throw new PerceptronConfigurationException('You have to specify at least one output');
        }

        return new Perceptron(
            $this->bias,
            $this->learningRate,
            $this->propagationStrategy,
            $this->inputs,
            $this->outputs,
            $this->hiddenLayers
        );
    }
}
