<?php declare( strict_types=1 );

$result = $connection->getOutgoingTransactions( $_SESSION[ "loginId" ] );

switch( $result )
{
	case ReturnCodes::TRANSACTION_LIST_EMPTY:
		echo( "<br>No outgoing transactions to show<br>" );
		break;

	case ReturnCodes::TRANSACTION_LIST_FILLED:
		echo( "<br>outgoing transactions:<br>" );
		
		$table = $connection->getTable();
		echo( $table->getFull() );
		break;

	default:
		echo( ReturnCodes::ERROR_MESSAGE );
}
?>