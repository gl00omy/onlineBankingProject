<?php declare( strict_types=1 );

$connection->queryDatabase( "SELECT * FROM ".Database::TABLE_TRANSACTIONS );
$table = $connection->getTable();

echo( $table->getFull()."<br><br>" );

$result = $connection->getIncomingTransactions( $_SESSION[ "loginId" ] );

switch( $result )
{
	case ReturnCodes::TRANSACTION_LIST_EMPTY:
		echo( "<br>No incoming transactions to show<br>" );
		break;

	case ReturnCodes::TRANSACTION_LIST_FILLED:
		echo( "<br>incoming transactions<br>" );
		
		$table = $connection->getTable();
		echo( $table->getFull() );
		break;

	default:
		echo( ReturnCodes::ERROR_MESSAGE );
}
?>