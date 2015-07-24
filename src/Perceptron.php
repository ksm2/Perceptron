<?php

namespace CherryPick\Component\Perceptron;

/**
 * @package CherryPick\Component\Perceptron
 * @author moellers
 */
class Perceptron extends AbstractPerceptron
{

    private $incomingWeights = array();
    private $outgoingWeights = array();

    /**
     * Tests the perceptron by given input data
     * and an output data container.
     *
     * @param mixed $input
     * @param mixed &$output
     * @return mixed
     */
    public function test($input, $output = array())
    {
        $this->getInputLayer()->setNamedValues($input);

        // Forward prop
        $layerInFront = $this->getInputLayer();
        for ($pos = 1; $pos < count($this->getLayers()); $pos++) {
            $layer = $this->getLayers()[$pos];
            foreach ($layer->getNodes() as $node) {
                $node->value = $this->getPropagationStrategy()->calculateValue($this, $node, $layerInFront);
            }

            // Process the next layer.
            $layerInFront = $layer;
        }

        return $this->getOutputLayer()->getNamedValues();
    }

    /**
     * Trains all perceptron weights by given input data
     * and expected outputs.
     *
     * @param mixed $input
     * @param mixed $expectedOutput
     * @return $this
     */
    public function train($input, $expectedOutput)
    {
        // Run the forward propagation first.
        $this->test($input);

        // Copy fields.
        $strategy = $this->getPropagationStrategy();
        $layers = $this->getLayers();

        // Init for first iteration.
        $layer = end($layers);
        $layerInFront = prev($layers);

        foreach ($layer->getNamedNodes() as $name => $node) {
            $node->delta = $strategy->calculateOutputDelta($this, $node, $expectedOutput[$name]);
            $this->updateNodesInFront($layerInFront, $node);
        }

        // Process the previous layer.
        $layerBehind = $layer;
        $layer = $layerInFront;
        $layerInFront = prev($layers);

        // Backpropagation.
        while ($layerInFront !== false) {
            foreach ($layer->getNodes() as $node) {
                $node->delta = $strategy->calculateHiddenDelta($this, $node, $layerBehind);
                $this->updateNodesInFront($layerInFront, $node);
            }

            // Process the previous layer.
            $layerBehind = $layer;
            $layer = $layerInFront;
            $layerInFront = prev($layers);
        }

        return $this;
    }

    /**
     * Initializes all perceptron weights with values.
     *
     * @return $this
     */
    public function initialize()
    {
        $this->incomingWeights = array();
        $this->outgoingWeights = array(0 => array());

        foreach ($this->getLayers() as $layer) {
            $behind = $this->findLayerBehind($layer);

            // We have reached the last layer, so we have
            // set all weights.
            if (null === $behind) {
                break;
            }

            $this->incomingWeights[$behind->getPosition()] = array();
            foreach ($layer->getNodes() as $from) {
                foreach ($behind->getNodes() as $to) {
                    $this->setWeight($from, $to, mt_rand(-1, 1));
                }
            }
        }
    }

    /**
     * Returns the weight between two nodes.
     *
     * @param Node $from
     * @param Node $to
     * @return float
     */
    public function getWeight(Node $from, Node $to)
    {
        return $this->outgoingWeights[$from->layer->getPosition()][$from->id][$to->id];
    }

    /**
     * Sets the weight between two nodes.
     *
     * @param Node $from
     * @param Node $to
     * @param float $value
     * @return $this
     */
    public function setWeight(Node $from, Node $to, $value)
    {
        $this->incomingWeights[$to->layer->getPosition()][$to->id][$from->id] = $value;
        $this->outgoingWeights[$from->layer->getPosition()][$from->id][$to->id] = $value;

        return $this;
    }

    /**
     * Decreases the weight between two nodes.
     *
     * @param Node $from
     * @param Node $to
     * @param float $subtrahend
     * @return $this
     */
    public function decreaseWeight(Node $from, Node $to, $subtrahend)
    {
        $this->incomingWeights[$to->layer->getPosition()][$to->id][$from->id] -= $subtrahend;
        $this->outgoingWeights[$from->layer->getPosition()][$from->id][$to->id] -= $subtrahend;

        return $this;
    }

    /**
     * Returns the outgoing weights from a node.
     *
     * @param Node $from
     * @return float[]
     */
    public function getOutgoingWeights(Node $from)
    {
        return $this->outgoingWeights[$from->layer->getPosition()][$from->id];
    }

    /**
     * Returns the incoming weights from a node.
     *
     * @param Node $to
     * @return float[]
     */
    public function getIncomingWeights(Node $to)
    {
        return $this->incomingWeights[$to->layer->getPosition()][$to->id];
    }

    /**
     * @param LayerInterface $layerInFront
     * @param Node $node
     */
    private function updateNodesInFront(LayerInterface $layerInFront, Node $node)
    {
        $multi = $this->getLearningRate() * $node->delta;

        foreach ($layerInFront->getNodes() as $nodeInFront) {
            $deltaWeight = $multi * $nodeInFront->value;
            $this->decreaseWeight($nodeInFront, $node, $deltaWeight);
        }
    }

    public function printWeights()
    {
        echo "========================================================\n";
        echo "WEIGHTS\n";
        foreach ($this->outgoingWeights as $layer => $nodes) {
            foreach ($nodes as $from => $tos) {
                foreach ($tos as $to => $value) {
                    echo sprintf("(%d.%d) -> (%d.%d) = %.5f\n", $layer, $from, $layer + 1, $to, $value);
                }
            }
            echo "\n";
        }
        echo "\n";
    }
}
