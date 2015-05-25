<?php

class CardCollectionTest extends PHPUnit_Framework_TestCase
{
    private $cardCollection;

    public function setUp()
    {
        $this->cardCollection = new CardCollection();
    }

    public function testCountOnEmpty()
    {
        $this->assertEquals(0, $this->cardCollection->count());
    }

    public function estAddCardAffectAttribute()
    {
        $card = new Card('A', 'Spades');

        $this->cardCollection->addCard($card);

        $this->assertAttributeEquals(array($card), 'cards', $this->cardCollection);
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
    public function testGetTopCard(CardCollection $cardCollection)
    {
        $card = $cardCollection->getTopCard();

        $this->assertEquals(new Card('2', 'Spades'), $card);
    }
}
