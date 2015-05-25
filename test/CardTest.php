<?php

class CardTest extends PHPUnit_Framework_TestCase
{
    private $card;

    public function setUp()
    {
        $this->card = new Card('4', 'spades');
    }

    public function testGetNumber()
    {
        $actualNumber = $this->card->getNumber();
        $this->assertEquals(4, $actualNumber, 'Number should be <4>');
    }

    public function testGetSuit()
    {
        $actualSuit = $this->card->getSuit();
        $this->assertEquals('spades', $actualSuit, 'Suit should be <spades>');
    }

    public function matchingCardDataProvider()
    {
        return array(
            '4 of Hearts' => array(new Card('4', 'hearts'), true, 'should match'),
            '5 of Hearts' => array(new Card('5', 'hearts'), false, 'should not match'),
            '4 of Clubs' => array(new Card('4', 'clubs'), true, 'should match')
        );
    }

    /**
     * @dataProvider matchingCardDataProvider
     */
    public function testIsInMatchingSet(Card $matchingCard, $expected, $msg)
    {
        $this->assertEquals($expected, $this->card->isInMatchingSet($matchingCard),
            "<{$this->card->getNumber()} of {$this->card->getSuit()}> {$msg} "
                . "<{$matchingCard->getNumber()} of {$matchingCard->getSuit()}>");
    }
}

