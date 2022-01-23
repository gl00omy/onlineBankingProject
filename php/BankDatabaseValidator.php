<?php declare( strict_types=1 );

abstract class BankDatabaseValidator
{
	public static String $_LOCALHOST = "mysql:host=localhost";
	public static String $_ROOT = "root";
	public static String $_DATABASE_NAME = "onlineBanking";

	private static array $_COMMANDS = array
	(
		"CREATE TABLE account
		(
			id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			firstname VARCHAR(20) NOT NULL,
			lastname VARCHAR(20) NOT NULL,
			username VARCHAR(20) NOT NULL,
			password VARCHAR(20) NOT NULL,
			email VARCHAR(50) NOT NULL,
			balance INT(9),
			registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)",

		"CREATE TABLE transactions
		(
			transaction_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			sender_id INT(9) NOT NULL,
			recipient_id INT(9) NOT NULL,
			excecution_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			amount INT(9) NOT NULL,
			message VARCHAR(100)
		)"
	);

	public static function verifyIntegrity() : void
	{
		$connection = BankDatabaseValidator::connectToDatabase( BankDatabaseValidator::$_LOCALHOST );
		BankDatabaseValidator::createDatabase( $connection );

		$connection = BankDatabaseValidator::connectToDatabase(
			BankDatabaseValidator::$_LOCALHOST.";dbname=".BankDatabaseValidator::$_DATABASE_NAME
		);
		BankDatabaseValidator::createTables( $connection );
	}

	private static function connectToDatabase( String $database) : PDO
	{
		try
		{
			$connection = new PDO
			(
				$database,
				BankDatabaseValidator::$_ROOT,
				null,
				array( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION )
			);

			return $connection;
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );
		}
	}

	private static function createDatabase( PDO &$connection ) : void
	{
		try
		{
			BankDatabaseValidator::queryDatabase( $connection, "CREATE DATABASE ".BankDatabaseValidator::$_DATABASE_NAME );
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );
		}
	}

	private static function createTables( PDO &$connection) : void
	{
		foreach( BankDatabaseValidator::$_COMMANDS as $command )
		{
			try
			{
				BankDatabaseValidator::queryDatabase( $connection, $command );
			}
			catch( PDOException $e )
			{
				echo( $e->getMessage()."<br>" );
			}
		}
	}

	private static function queryDatabase( PDO $connection, String $query, array $options = [] ) : void
	{
		try
		{
			$statement = $connection->prepare( $query, $options );
			$statement->execute();

			echo( "Query ($query) executed successfully"."<br>" );
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );
		}
	}
}
?>