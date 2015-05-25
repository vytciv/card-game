<?php

class PhakeHumanPlayerTest extends PHPUnit_Framework_TestCase
{
    private $player;

    /**
     * @Mock CardCollection
     */
    private $hand;

    public function setUp()
    {
        Phake::initAnnotations($this);
        $this->player = new HumanPlayer('John Smith', $this->hand);
    }

    public function testDrawCard()
    {
        $deck = Phake::mock('CardCollection');
        $this->player->drawCard($deck);
        Phake::verify($deck)->moveTopCardTo($this->identicalTo($this->hand));
    }

    public function testTakeCardFromPlayer()
    {
        $otherHand = Phake::mock('CardCollection');
        $otherPlayer = Phake::mock('HumanPlayer');
        $card = Phake::mock('Card');

        Phake::when($otherPlayer)->getCard(Phake::anyParameters())->thenReturn($card);
        Phake::when($otherPlayer)->getHand()->thenReturn($otherHand);

        $this->assertTrue($this->player->takeCards($otherPlayer, 4));

        Phake::verify($this->hand)->addCard($this->identicalTo($card));
        Phake::verify($otherHand)->removeCard($this->identicalTo($card));
    }
}
