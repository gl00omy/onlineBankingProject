<?php declare( strict_types=1 );

function getIncomingTransactionsTable( String $amountOrdering, String $dateOrdering ) : String
{
	return getTransactionsTable( Queries::INCOMING, $amountOrdering, $dateOrdering );
}

function getOutcomingTransactionsTable( String $amountOrdering, String $dateOrdering ) : String
{
	return getTransactionsTable( Queries::OUTCOMING, $amountOrdering, $dateOrdering );
}

function getTransactionsTable
(
	String $typeOfTransactions,
	String $amountOrdering,
	String $dateOrdering
) : String
{
	global $connection;
	$result = $connection->getTransactions( $typeOfTransactions, $amountOrdering, $dateOrdering );

	switch( $result )
	{
		case ReturnCodes::TRANSACTION_LIST_EMPTY:
			return "No $typeOfTransactions transactions to show";

		case ReturnCodes::TRANSACTION_LIST_FILLED:
			return $connection->getTable()->getFull();

		default:
			return ReturnCodes::ERROR_MESSAGE;
	}
}
?>