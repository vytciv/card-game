<?php

/**
 * Models a collection of cards such as a hand or a deck.
 */
class CardCollection implements IteratorAggregate
{
    /**
     * @var array
     */
    private $cards = array();

    /**
     * Adds a new card
     * @param Card $card
     */
    public function addCard(Card $card)
    {
        array_push($this->cards, $card);
    }


    public function getTopCard()
    {
        if ($this->count()) {
            return $this->cards[count($this->cards) - 1];
        } else {
            return null;
        }
    }

    /**
     * Moves the top card in this collection to another collection.
     *
     * @param CardCollection $collection
     */
    public function moveTopCardTo(CardCollection $collection)
    {
        $card = array_pop($this->cards);
        if ($card !== null) {
            $collection->addCard($card);
        }
    }

    /**
     * Shuffles the order of all cards in the hand
     */
    public function shuffle()
    {
        shuffle($this->cards);
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
}
