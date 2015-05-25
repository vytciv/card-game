<?php

class MockBuilderHumanPlayerTest extends PHPUnit_Framework_TestCase
{
    private $player;
    private $hand;

    public function setUp()
    {
        $this->hand = $this->getMock('CardCollection');
        $this->player = new HumanPlayer('John Smith', $this->hand);
    }

    public function testDrawCard()
    {
        $deck = $this->getMock('CardCollection');
        $deck->expects($this->once())
            ->method('moveTopCardTo')
            ->with($this->identicalTo($this->hand));

        $this->player->drawCard($deck);
    }

    public function testTakeCardFromPlayer()
    {
        $otherHand = $this->getMock('CardCollection');
        $otherPlayer = $this->getMockBuilder('HumanPlayer')
            ->disableOriginalConstructor()
            ->getMock();
        $card = $this->getMockBuilder('Card')
            ->disableOriginalConstructor()
            ->getMock();

        $otherPlayer->expects($this->once())
            ->method('getCard')
            ->with(4)
            ->will($this->returnValue($card));

        $otherPlayer->expects($this->once())
            ->method('getHand')
            ->will($this->returnValue($otherHand));

        $this->hand->expects($this->once())
            ->method('addCard')
            ->with($this->identicalTo($card));

        $otherHand->expects($this->once())
            ->method('removeCard')
            ->with($this->identicalTo($card));

        $this->assertTrue($this->player->takeCards($otherPlayer, 4));
    }
}
