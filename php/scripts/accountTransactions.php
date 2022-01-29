<?php declare( strict_types=1 );

if( $_SERVER[ "REQUEST_METHOD" ] === "POST" && !isInputEmpty() )
{
	$recipientId = intval( $_POST[ "recipientId" ] );
	$amount = intval( $_POST[ "amount" ] );
	$message = $_POST[ "message" ];

	$result = $connection->excecuteTransaction( $recipientId, $amount, $message );

	switch( $result )
	{
		case ReturnCodes::TRANSACTION_RECIPIENT_SELF:
			$recipientIdErrMsg = "Entered ID corresponds to your own";
			break;

		case ReturnCodes::TRANSACTION_RECIPIENT_NOT_FOUND:
			$recipientIdErrMsg = "Selected account doesn't exist";
			break;

		case ReturnCodes::TRANSACTION_AMOUNT_LIMIT_OVER:
			$amountErrMsg = "Insufficient balance";
			break;

		case ReturnCodes::TRANSACTION_AMOUNT_LIMIT_EQUAL:
			$amountErrMsg = "The entered amount would leave you with an empty balance";
			break;

		case ReturnCodes::TRANSACTION_AMOUNT_SUCCESS:
			header( "Location: http://localhost/onlineBankingProject/my_account.php", true, 301 );
			
			$excecutionMessage = "Transaction executed succesfully";
			break;


		default:
			echo( ReturnCodes::ERROR_MESSAGE );
	}
}

function isInputEmpty() : bool
{
	return empty( $_POST[ "recipientId" ] ) || empty( $_POST[ "amount" ] );
}

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
		case ReturnCodes::TRANSACTION_TABLE_EMPTY:
			return "No $typeOfTransactions transactions to show";

		case ReturnCodes::TRANSACTION_TABLE_FILLED:
			return $connection->getTable()->getFull();

		default:
			return ReturnCodes::ERROR_MESSAGE;
	}
}

?>