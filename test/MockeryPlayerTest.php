<?php

class MockeryPlayerTest extends PHPUnit_Framework_TestCase
{
    private $player;
    private $hand;

    public function setUp()
    {
        $this->hand = \Mockery::mock('CardCollection');
        $this->player = new HumanPlayer('John Smith', $this->hand);
    }

    public function testDrawCard()
    {
        $deck = \Mockery::mock('CardCollection');
        $deck->shouldReceive('moveTopCardTo')->once()
            ->with($this->hand);

        $this->player->drawCard($deck);
    }

    public function testTakeCardFromPlayer()
    {
        $otherHand = \Mockery::mock('CardCollection');
        $otherPlayer = \Mockery::mock('HumanPlayer');
        $card = new Card('A', 'Spades');

        $otherPlayer->shouldReceive('getCard')
            ->with(4)
            ->andReturn($card);

        $otherPlayer->shouldReceive('getHand')
            ->andReturn($otherHand);

        $this->hand->shouldReceive('addCard')
            ->with($card);

        $otherHand->shouldReceive('removeCard')
            ->with($card);

        $this->assertTrue($this->player->takeCards($otherPlayer, 4));
    }
}
