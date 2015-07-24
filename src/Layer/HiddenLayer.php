<?php

namespace CherryPick\Component\Perceptron\Layer;

/**
 * @package CherryPick\Component\Perceptron\Layer
 * @author moellers
 */
class HiddenLayer extends AbstractLayer
{

    /**
     * HiddenLayer constructor.
     * @param $numberOfNodes
     */
    public function __construct($numberOfNodes)
    {
        for ($i = 0; $i < $numberOfNodes; $i++) {
            $this->addNode();
        }
    }

    /**
     * @return bool
     */
    public function isHiddenLayer()
    {
        return true;
    }
}
