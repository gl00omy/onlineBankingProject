<?php declare( strict_types=1 );

include "DatabaseConnection.php";
include "BankDatabaseValidator.php";

BankDatabaseValidator::verifyIntegrity();

$connection = new DatabaseConnection( BankDatabaseValidator::$_DATABASE_NAME );

// initializeDatabase( $connection );

$connection->queryDatabase( "SELECT * FROM account" );
// $table = $connection->getTable();

// echo( $table->getFullTable() );
// echo( $table->getHeadersTable() );
// echo( $table->getValuesTable() );
echo( "affected rows: ".$connection->getAffectedRows()."<br>" );

$connection->queryDatabase( "SELECT * FROM transactions" );
// $table = $connection->getTable();

// echo( $table->getFullTable() );
// echo( $table->getHeadersTable() );
// echo( $table->getValuesTable() );
echo( "affected rows: ".$connection->getAffectedRows()."<br>" );

function initializeDatabase( DatabaseConnection $connection )
{
	try
	{
		$connection->queryDatabase(
			"CREATE TABLE MyGuests
			(
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				firstname VARCHAR(30) NOT NULL,
				lastname VARCHAR(30) NOT NULL,
				email VARCHAR(50),
				reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			)"
		);

		// prepare sql and bind parameters
		$stmt = $connection->prepare
		(
			"INSERT INTO MyGuests (firstname, lastname, email)
			VALUES (:firstname, :lastname, :email)"
		);

		$stmt->bindParam( ':firstname', $firstname );
		$stmt->bindParam( ':lastname', $lastname );
		$stmt->bindParam( ':email', $email );

		// insert first row
		$firstname = "John";
		$lastname = "Doe";
		$email = "john@example.com";
		$stmt->execute();

		// insert another row
		$firstname = "Mary";
		$lastname = "Moe";
		$email = "mary@example.com";
		$stmt->execute();

		// insert another row
		$firstname = "Julie";
		$lastname = "Dooley";
		$email = "julie@example.com";
		$stmt->execute();

		echo( "Added multiple records" );
	}
	catch( PDOException $e )
	{
		// roll back the transaction if something failed
		$connection->rollback();

		echo( $e->getMessage() );
	}
}
?>