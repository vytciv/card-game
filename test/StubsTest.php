<?php

class StubsTest extends PHPUnit_Framework_TestCase
{
    public function testThrowException()
    {
        $card = $this->getMock('Card', array(), array(), '', false);

        $card->expects($this->any())
            ->method('getNumber')
            ->will($this->throwException(new RuntimeException('Test Exception')));

        $this->setExpectedException('RuntimeException', 'Test Exception');
        $card->getNumber();
    }

    public function testReturnValueMap()
    {
        $calculator = $this->getMock('TestCalculator');

        $valueMap = array(
            array(1, 2, 3),
            array(2, 4, 6),
            array(1, 4, 5)
        );

        $calculator->expects($this->any())
            ->method('add')
            ->will($this->returnValueMap($valueMap));

        // Test Return Values
        $this->assertEquals(3, $calculator->add(1, 2));
        $this->assertEquals(6, $calculator->add(2, 4));
        $this->assertEquals(5, $calculator->add(1, 4));
        $this->assertNull($calculator->add(1, 3));
    }

    public function testOnConsecutiveCalls()
    {
        $deck = $this->getMock('CardCollection');

        $deck->expects($this->any())
            ->method('count')
            ->will($this->onConsecutiveCalls(3, 2, 1));

        // Test Return Values
        $this->assertEquals(3, $deck->count());
        $this->assertEquals(2, $deck->count());
        $this->assertEquals(1, $deck->count());
        $this->assertNull($deck->count());
    }

    public function testReturnCallback()
    {
        $deck = $this->getMock('CardCollection');

        $deck->expects($this->any())
            ->method('addCard')
            ->will($this->returnCallback(function (Card $card) {
                static $collectionSize = 0;
                $collectionSize++;
                return $collectionSize;
            }));

        // Test Return Values
        $this->assertEquals(1, $deck->addCard(new Card('A', 'Hearts')));
        $this->assertEquals(2, $deck->addCard(new Card('2', 'Hearts')));
        $this->assertEquals(3, $deck->addCard(new Card('3', 'Hearts')));
    }
}

interface TestCalculator
{
    public function add($x, $y);
}