<?php declare( strict_types=1 );

require "classes/DatabaseConnection.php";

$connection = new DatabaseConnection( Database::DATABASE_NAME );

initializeDatabase( $connection );

function initializeDatabase( DatabaseConnection $connection )
{
	try
	{
		initializeAccountTable( $connection );
		initializeTransactionTable( $connection );
	}
	catch( PDOException $e )
	{
		$connection->rollback();

		echo( $e->getMessage() );
	}
}

function initializeAccountTable( DatabaseConnection $connection )
{
	$stmt = $connection->prepare
	(
		"INSERT INTO ".Database::TABLE_ACCOUNTS." (id, firstname, lastname, email, password)
		VALUES (:id, :firstname, :lastname, :email, :password)"
	);

	$stmt->bindParam( ':id', $id );
	$stmt->bindParam( ':firstname', $firstName );
	$stmt->bindParam( ':lastname', $lastName );
	$stmt->bindParam( ':password', $password );
	$stmt->bindParam( ':email', $email );

	$id = 1;
	$firstName = "ajeje";
	$lastName = "brazorf";
	$password = "passwordAjeje";
	$email = $firstName.".".$lastName."@patagarro.com";
	$stmt->execute();

	$id = 2;
	$firstName = "brambilla";
	$lastName = "fumagalli";
	$password = "passwordBrambilla";
	$email = $firstName.".".$lastName."@patagarro.com";
	$stmt->execute();

	$id = 3;
	$firstName = "pdor";
	$lastName = "kmer";
	$password = "passwordPdor";
	$email = $firstName.".".$lastName."@patagarro.com";
	$stmt->execute();

	echo( "Added multiple records to accounts<br>" );
}

function initializeTransactionTable( DatabaseConnection $connection )
{
	$stmt = $connection->prepare
	(
		"INSERT INTO ".Database::TABLE_TRANSACTIONS." (transaction_id, sender_id, recipient_id, amount, message)
		VALUES (:transaction_id, :sender_id, :recipient_id, :amount, :message)"
	);

	$stmt->bindParam( ':transaction_id', $transaction_id );
	$stmt->bindParam( ':sender_id', $sender_id );
	$stmt->bindParam( ':recipient_id', $recipient_id );
	$stmt->bindParam( ':amount', $amount );
	$stmt->bindParam( ':message', $message );

	$transaction_id = 1;
	$sender_id = 1;
	$recipient_id = 2;
	$amount = 69;
	$message = "transaction $sender_id to $recipient_id of €$amount";
	$stmt->execute();

	$transaction_id = 2;
	$sender_id = 2;
	$recipient_id = 3;
	$amount = 138;
	$message = "transaction $sender_id to $recipient_id of €$amount";
	$stmt->execute();

	$transaction_id = 3;
	$sender_id = 3;
	$recipient_id = 1;
	$amount = 420;
	$message = "transaction $sender_id to $recipient_id of €$amount";
	$stmt->execute();

	echo( "Added multiple records to transactions" );
}
?>