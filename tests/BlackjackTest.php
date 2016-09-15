<?php
    require_once __DIR__.'/../src/Blackjack.php';

    class BlackjackTest extends PHPUnit_Framework_TestCase
    {
        function test_getDeck_deckLengthAndCardOutputStyle()
        {
            //Arrange
            $test_Blackjack = new Blackjack;
            //Act
            $test_Blackjack->initialDeal();
            $output = $test_Blackjack->getDeck();
            //Assert
            $this->assertEquals(48, sizeof($output->cards));
        }

    }
 ?>
