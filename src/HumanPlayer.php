<?php
/**
 * Represents a human player.
 */
class HumanPlayer extends Player
{
    /**
     * Allows a player to select a card from their hand.
     *
     * @return string
     */
    protected function chooseCardNumber()
    {
        echo "Current Hand: ";
        $numbers = array();
        /* @var $card Card */
        foreach ($this->getHand() as $card) {
            $numbers[] = $card->getNumber();
            echo $card->getNumber(), substr($card->getSuit(), 0, 1), ' ';
        }

        echo "\n\nWhat card would you like to request? (number only, no suite necessary) ";

        $requestedCard = strtoupper(trim(fgets(STDIN)));

        while (!in_array($requestedCard, $numbers)) {
            echo "That is not a valid selection, please try again: ";
            $requestedCard = strtoupper(trim(fgets(STDIN)));
        }

        return $requestedCard;
    }
}
