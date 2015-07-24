<?php

namespace CherryPick\Component\Perceptron\Layer;

use CherryPick\Component\Perceptron\Exception\PerceptronInitializingException;
use CherryPick\Component\Perceptron\Node;

/**
 * @package CherryPick\Component\Perceptron\Exception\Perceptron\Layer
 * @author moellers
 */
class NamedLayer extends AbstractLayer
{

    /**
     * @var Node[]
     */
    private $namedNodes = array();

    /**
     * NamedLayer constructor.
     * @param $names
     */
    public function __construct(array $names)
    {
        $this->setNames($names);
    }

    /**
     * @return bool
     */
    public function isHiddenLayer()
    {
        return false;
    }

    /**
     * @param float[] $values
     * @throws PerceptronInitializingException
     */
    public function setNamedValues(array $values)
    {
        foreach ($values as $name => $value) {
            if (!isset($this->namedNodes[$name])) {
                throw new PerceptronInitializingException(sprintf('There is no node named %s', $name));
            }

            $this->namedNodes[$name]->value = $value;
        }
    }

    /**
     * @return float[]
     */
    public function getNamedValues()
    {
        $output = array();
        foreach ($this->namedNodes as $name => $node) {
            $output[$name] = $node->value;
        }

        return $output;
    }

    /**
     * @return \CherryPick\Component\Perceptron\Node[]
     */
    public function getNamedNodes()
    {
        return $this->namedNodes;
    }

    /**
     * @param array $names
     */
    protected function setNames(array $names)
    {
        $this->namedNodes = array();
        foreach ($names as $name) {
            $this->namedNodes[$name] = $this->addNode();
        }
    }
}
