<?php

namespace CherryPick\Component\Perceptron;

/**
 * @package CherryPick\Component\Perceptron
 * @author moellers
 */
interface LayerInterface
{

    /**
     * Returns the position of the layer within the perceptron.
     *
     * @return int
     */
    public function getPosition();

    /**
     * Changes the position of the layer.
     *
     * @param int $position
     * @return $this
     */
    public function setPosition($position);

    /**
     * Returns all contained nodes.
     *
     * @return Node[]
     */
    public function getNodes();

    /**
     * Returns all node values.
     *
     * @return float[]
     */
    public function getValues();

    /**
     * Returns all node deltas.
     *
     * @return float[]
     */
    public function getDeltas();

    /**
     * @return bool
     */
    public function isHiddenLayer();
}
