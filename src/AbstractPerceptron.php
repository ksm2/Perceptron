<?php

namespace CherryPick\Component\Perceptron;

use CherryPick\Component\Perceptron\Exception\PerceptronInitializingException;
use CherryPick\Component\Perceptron\Layer\HiddenLayer;
use CherryPick\Component\Perceptron\Layer\NamedLayer;

/**
 * @package CherryPick\Component\Perceptron
 * @author moellers
 */
abstract class AbstractPerceptron implements PerceptronInterface
{

    /**
     * @var float
     */
    private $bias;

    /**
     * @var float
     */
    private $learningRate;

    /**
     * @var PropagationStrategyInterface
     */
    private $propagationStrategy;

    /**
     * @var LayerInterface[]
     */
    private $layers = array();

    /**
     * @var NamedLayer
     */
    private $inputLayer;

    /**
     * @var NamedLayer
     */
    private $outputLayer;

    /**
     * AbstractPerceptron constructor.
     *
     * @param float $bias
     * @param float $learningRate
     * @param PropagationStrategyInterface $propagationStrategy
     * @param array $inputs
     * @param array $outputs
     * @param array $hiddenLayers
     */
    public function __construct(
        $bias,
        $learningRate,
        PropagationStrategyInterface $propagationStrategy,
        array $inputs,
        array $outputs,
        array $hiddenLayers
    )
    {
        // Store parameters.
        $this->bias = $bias;
        $this->learningRate = $learningRate;
        $this->propagationStrategy = $propagationStrategy;

        // Create input and output layers.
        $this->inputLayer = $this->insertLayer(0, new NamedLayer($inputs));
        $this->outputLayer = $this->insertLayer(1, new NamedLayer($outputs));

        $this->initializeHiddenLayers($hiddenLayers);
    }

    /**
     * @return float
     */
    final public function getBias()
    {
        return $this->bias;
    }

    /**
     * @return float
     */
    final public function getLearningRate()
    {
        return $this->learningRate;
    }

    /**
     * @return PropagationStrategyInterface
     */
    final public function getPropagationStrategy()
    {
        return $this->propagationStrategy;
    }

    /**
     * @return LayerInterface[]
     */
    final public function getLayers()
    {
        return $this->layers;
    }

    /**
     * Inserts a layer at a given position.
     *
     * @param $index
     * @param LayerInterface $layer
     * @return LayerInterface
     */
    protected function insertLayer($index, LayerInterface $layer)
    {
        for ($i = count($this->layers); $i > $index; $i--) {
            $this->layers[$i] = $this->layers[$i - 1];
            $this->layers[$i]->setPosition($i);
        }

        $this->layers[$index] = $layer;
        $layer->setPosition($index);
        return $layer;
    }

    /**
     * @return NamedLayer
     */
    protected function getInputLayer()
    {
        return $this->inputLayer;
    }

    /**
     * @return NamedLayer
     */
    protected function getOutputLayer()
    {
        return $this->outputLayer;
    }

    /**
     * @param LayerInterface $layer
     * @return LayerInterface|null
     * @throws PerceptronInitializingException
     */
    protected function findLayerBehind(LayerInterface $layer)
    {
        $index = array_search($layer, $this->layers);

        if ($index === false) {
            throw new PerceptronInitializingException('Could not find the given layer.');
        }

        $index++;

        if (!isset($this->layers[$index])) {
            return null;
        }

        return $this->layers[$index];
    }

    /**
     * Initializes the hidden layers.
     *
     * @param array $hiddenLayers
     */
    private function initializeHiddenLayers(array $hiddenLayers)
    {
        $index = 1;
        foreach ($hiddenLayers as $numberOfNodes) {
            $this->insertLayer($index, new HiddenLayer($numberOfNodes));
            $index++;
        }
    }
}
