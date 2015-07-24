<?php

namespace CherryPick\Component\Perceptron\Layer;

use CherryPick\Component\Perceptron\LayerInterface;
use CherryPick\Component\Perceptron\Node;

/**
 * @package Layer
 * @author moellers
 */
abstract class AbstractLayer implements LayerInterface
{

    /**
     * @var int
     */
    private $position;

    /**
     * @var Node[]
     */
    private $nodes = array();

    /**
     * @return int
     */
    final public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return $this
     */
    final public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return Node[]
     */
    final public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Returns all node values.
     *
     * @return float[]
     */
    final public function getValues()
    {
        return array_map(
            function (Node $node) {
                return $node->value;
            },
            $this->nodes
        );
    }

    /**
     * Returns all node deltas.
     *
     * @return float[]
     */
    final public function getDeltas()
    {
        return array_map(
            function (Node $node) {
                return $node->delta;
            },
            $this->nodes
        );
    }

    /**
     * @return Node
     */
    protected function addNode()
    {
        $node = new Node();
        $node->id = count($this->nodes);
        $node->layer = $this;

        $this->nodes[] = $node;

        return $node;
    }
}
