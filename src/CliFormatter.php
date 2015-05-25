<?php

/**
 * A cli based output formatter for the game
 */
class CliFormatter
{
    /**
     * Called when a player's Prints a player's hand
     *
     * @param Player $player
     */
    public function announcePlayerHand(Player $player)
    {
        echo "Current Hand: ", $this->getCards($player->getHand()), "\n\n";
    }

    /**
     * Prints a player's new match
     *
     * @param Player $player
     * @param Card $card1
     * @param Card $card2
     */
    public function announceMatch(Player $player, Card $card1, Card $card2)
    {
        echo sprintf("%s, you have a match: %s and %s\n", $player->getName(), $this->getCard($card1), $this->getCard($card2));
    }

    /**
     * Prints the game score
     *
     * @param callable $printScore
     */
    public function announceScore(Closure $printScore)
    {
        echo "\nCurrent Score\n";
        echo "-----------------------\n";
        $printScore(function (Player $player, $score) {
            echo str_pad(substr($player->getName(), 0, 20), 21, ' ', STR_PAD_RIGHT), str_pad($score, 2, ' ', STR_PAD_LEFT), "\n";
        });
        echo "-----------------------\n\n";
    }

    /**
     * A player can go again
     *
     * @param Player $player
     */
    public function announceReplay(Player $player)
    {
        echo $player->getName(), ", you get to go again!\n\n";
    }

    /**
     * A player's hand is empty
     *
     * @param Player $player
     */
    public function announceEmptyHand(Player $player)
    {
        echo $player->getName(), ", you had no cards left, you have been drawn a new hand!\n";
    }

    /**
     * A match was not made
     *
     * @param Player $player
     */
    public function announceGoFish(Player $player)
    {
        echo $player->getName(), ", go fish!\n";
    }

    /**
     * A match was drawn
     *
     * @param Player $player
     */
    public function announceMatchDrawn(Player $player)
    {
        echo $player->getName(), ", you drew a match!\n";
    }

    /**
     * A player's turn is over
     *
     * @param Player $player
     */
    public function announceTurnOver(Player $player)
    {
        echo $player->getName(), ", your turn is over. Press enter to continue!";
        fgets(STDIN);
        echo "\n";
    }

    /**
     * The beginning of a new turn
     *
     * @param Player $player
     */
    public function announceNewTurn(Player $player)
    {
        echo "{$player->getName()}, it is your turn!\n\n";
    }

    /**
     * A collection of cards represented as a string
     *
     * @param CardCollection $cards
     * @return string
     */
    private function getCards(CardCollection $cards)
    {
        $cardStr = '';
        /* @var $card Card */
        foreach ($cards as $card) {
            $cardStr .= $this->getCard($card) . ' ';
        }

        return $cardStr;
    }

    /**
     * A single card represented as a string
     *
     * @param Card $card
     * @return string
     */
    private function getCard(Card $card)
    {
        return $card->getNumber() . substr($card->getSuit(), 0, 1);
    }
}
