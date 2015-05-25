<?php

/**
 * Models a collection of cards such as a hand or a deck.
 *
 * Use on any class that acts as a collection of cards.
 */
trait CardCollectionTrait
{
    /**
     * @var array
     */
    protected $cards = array();

    /**
     * Adds a new card
     * @param Card $card
     */
    public function addCard(Card $card)
    {
        array_push($this->cards, $card);
    }

    /**
     * Removes the given card from the collection.
     *
     * @param Card $card
     */
    public function removeCard(Card $card)
    {
        $remainingCards = array();

        foreach ($this->cards as $checkCard) {
            if ($card !== $checkCard) {
                $remainingCards[] = $checkCard;
            }
        }

        $this->cards = $remainingCards;
    }

    /**
     * Gets the top card of a collection if there are cards. Otherwise returns null.
     * @return Card
     */
    public function getTopCard()
    {
        if ($this->count()) {
            return $this->cards[count($this->cards) - 1];
        } else {
            return null;
        }
    }

    /**
     * The number of cards in the collection
     * @return int
     */
    public function count()
    {
        return count($this->cards);
    }

    /**
     * Returns an iterator for the cards
     *
     * @return Iterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->cards);
    }
}
