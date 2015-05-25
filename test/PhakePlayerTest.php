<?php

class PhakePlayerTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Player
	 */
	private $player;
	private $hand;

	public function setUp()
	{
		$this->hand = new CardCollection();
		$this->hand->addCard( new Card( 'A', 'Spades' ) );
		$this->player = Phake::partialMock( 'Player', 'John Smith', $this->hand );
	}

	public function testRequestCardCallsChooseCardNumber()
	{
		Phake::when( $this->player )->chooseCardNumber()->thenReturn( 'A' );

		$this->assertEquals( 'A', $this->player->requestCard() );

		Phake::verify( $this->player )->chooseCardNumber();
	}
}
