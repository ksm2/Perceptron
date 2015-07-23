<?php

namespace CherryPick\Component\Perceptron;

/**
 * @package CherryPick\Component\Perceptron
 * @author moellers
 */
class Node
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var float
     */
    public $value;

    /**
     * @var float
     */
    public $delta;

    /**
     * @var LayerInterface
     */
    public $layer;
}
