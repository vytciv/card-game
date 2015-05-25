<?php

/**
 * Models an individual card.
 */
class Card
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $suit;

    /**
     * @param string $number
     * @param string $suit
     */
    public function __construct($number, $suit)
    {
        $this->number = $number;
        $this->suit = $suit;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * Returns true if the given card is in the same set
     * @param Card $card
     * @return bool
     * @assert (new Card(3, 'h'), new Card(3, 's')) == true
     * @assert (new Card(4, 'h'), new Card(3, 's')) == false
     */
    public function isInMatchingSet(Card $card)
    {
        return ($this->getNumber() == $card->getNumber());
    }
}

