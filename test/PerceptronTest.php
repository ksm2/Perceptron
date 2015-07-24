<?php

namespace CherryPick\Component\Perceptron\Tests;

use CherryPick\Component\Perceptron\Layer\NamedLayer;
use CherryPick\Component\Perceptron\PerceptronFactory;

/**
 * @package CherryPick\Component\Perceptron\Tests\Perceptron
 * @author moellers
 */
class PerceptronTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PerceptronFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new PerceptronFactory();
    }

    public function testLayerInitialization()
    {
        $this->factory->addHiddenLayer(3);
        $this->factory->addHiddenLayer(2);
        $this->factory->addHiddenLayer(4);
        $this->factory->setInputs(['x1', 'x2']);
        $this->factory->setOutputs(['y']);

        $perceptron = $this->factory->createPerceptron();

        $this->assertCount(5, $perceptron->getLayers());
        $this->assertCount(2, $perceptron->getLayers()[0]->getNodes());
        $this->assertCount(3, $perceptron->getLayers()[1]->getNodes());
        $this->assertCount(2, $perceptron->getLayers()[2]->getNodes());
        $this->assertCount(4, $perceptron->getLayers()[3]->getNodes());
        $this->assertCount(1, $perceptron->getLayers()[4]->getNodes());
    }

    public function testInputInitialization()
    {
        $this->factory->setInputs(['x1', 'x2']);
        $this->factory->setOutputs(['y']);

        $perceptron = $this->factory->createPerceptron();

        $this->assertCount(2, $perceptron->getLayers());

        $inputLayer = $perceptron->getLayers()[0];
        $this->assertInstanceOf(NamedLayer::class, $inputLayer);

        if ($inputLayer instanceof NamedLayer) {
            $namedValues = $inputLayer->getNamedValues();
            $this->assertCount(2, $namedValues);
            $this->assertArrayHasKey('x1', $namedValues);
            $this->assertArrayHasKey('x2', $namedValues);
        }
    }

    public function testOutputInitialization()
    {
        $this->factory->setInputs(['x1', 'x2']);
        $this->factory->setOutputs(['y']);

        $perceptron = $this->factory->createPerceptron();

        $this->assertCount(2, $perceptron->getLayers());

        $outputLayer = $perceptron->getLayers()[1];
        $this->assertInstanceOf(NamedLayer::class, $outputLayer);

        if ($outputLayer instanceof NamedLayer) {
            $namedValues = $outputLayer->getNamedValues();
            $this->assertCount(1, $namedValues);
            $this->assertArrayHasKey('y', $namedValues);
        }
    }

    public function testTrain()
    {
        $this->factory->setInputs(['x1', 'x2']);
        $this->factory->setOutputs(['y']);
        $this->factory->addHiddenLayer(3);
        $this->factory->addHiddenLayer(4);
        $this->factory->addHiddenLayer(2);

        $perceptron = $this->factory->createPerceptron();

        $perceptron->initialize();
        for ($i = 0; $i < 10000; $i++) {
            $x = mt_rand(0, 1);
            $y = mt_rand(0, 1);
            $perceptron->train(['x1' => $x, 'x2' => $y], ['y' => $x * $y]);
        }

        $x = 0.4;
        $y = 0.6;
        $result = $perceptron->test(['x1' => $x, 'x2' => $y]);
        var_dump($result['y'], $x * $y, abs($result['y'] - $x * $y));
    }
}
