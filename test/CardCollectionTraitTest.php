<?php

class CardCollectionTraitTest extends PHPUnit_Framework_TestCase
{
    private $cardCollection;

    public function setUp()
    {
        $this->cardCollection = $this->getObjectForTrait('CardCollectionTrait');
    }

    public function testCountOnEmpty()
    {
        $this->assertEquals(0, $this->cardCollection->count());
    }

    /**
     * @depends testCountOnEmpty
     */
    public function testAddCard()
    {
        $this->cardCollection->addCard(new Card('A', 'Spades'));
        $this->cardCollection->addCard(new Card('2', 'Spades'));

        $this->assertEquals(2, $this->cardCollection->count());

        return $this->cardCollection;
    }

    /**
     * @depends testAddCard
     */
    public function testGetTopCard($cardCollection)
    {
        $card = $cardCollection->getTopCard();

        $this->assertEquals(new Card('2', 'Spades'), $card);
    }
}
