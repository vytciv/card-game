<?php

/**
 * Generates cards
 */
class CardFactory
{

    /**
     * Returns a card collection containing a standard 52 card deck.
     *
     * @return CardCollection
     */
    public static function StandardDeck()
    {
        $deck = new CardCollection();

        $suites = array('Hearts', 'Spades', 'Diamonds', 'Clubs');
        $numbers = array('A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K');

        foreach ($suites as $suite) {
            foreach ($numbers as $number) {
                $deck->addCard(new Card($number, $suite));
            }
        }

        return $deck;
    }
}
