<?php

class PlayerTest extends PHPUnit_Framework_TestCase
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
		$this->player = $this->getMockForAbstractClass( 'Player', array( 'John Smith', $this->hand ) );
	}

	public function testRequestCardCallsChooseCardNumber()
	{
		$this->player->expects( $this->once() )
		             ->method( 'chooseCardNumber' )
		             ->will( $this->returnValue( 'A' ) );

		$this->assertEquals( 'A', $this->player->requestCard() );
	}

	public function testRequestCardThrowsOnInvalidCard()
	{
		$this->player->expects( $this->once() )
		             ->method( 'chooseCardNumber' )
		             ->will( $this->returnValue( '2' ) );

		$this->setExpectedException( 'RuntimeException', 'Invalid card chosen by player' );
		$this->player->requestCard();
	}

	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionMessage Invalid card chosen by player
	 */
	public function testRequestCardThrowsOnInvalidCardUsingAnnotation()
	{
		$this->player->expects( $this->once() )
		             ->method( 'chooseCardNumber' )
		             ->will( $this->returnValue( '2' ) );

		$this->player->requestCard();
	}
}
