<?php declare( strict_types=1 );

require "Database.php";

abstract class DatabaseValidator implements Database
{
	private static String $_DATABASE_COMMAND =
	(
		"CREATE DATABASE IF NOT EXISTS `".Database::DATABASE_NAME."`"
	);

	private static array $_TABLE_COMMANDS = array
	(
		"CREATE TABLE IF NOT EXISTS `".Database::TABLE_ACCOUNTS."`
		(
			id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			firstname VARCHAR(20) NOT NULL,
			lastname VARCHAR(20) NOT NULL,
			email VARCHAR(60) NOT NULL,
			password VARCHAR(20) NOT NULL,
			balance INT(9) DEFAULT 50,
			registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)",

		"CREATE TABLE IF NOT EXISTS `".Database::TABLE_TRANSACTIONS."`
		(
			transaction_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			sender_id INT(9) UNSIGNED NOT NULL,
			recipient_id INT(9) UNSIGNED NOT NULL,
			amount INT(9) UNSIGNED NOT NULL,
			excecution_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			message VARCHAR(100),

			CONSTRAINT FK_sender_id FOREIGN KEY (sender_id) REFERENCES Accounts(id),
			CONSTRAINT FK_recipient_id FOREIGN KEY (recipient_id) REFERENCES Accounts(id)
		)"
	);

	public static function verifyIntegrity() : void
	{
		$connection = DatabaseValidator::connectToDatabase( Database::LOCALHOST );
		DatabaseValidator::createDatabase( $connection );

		$connection = DatabaseValidator::connectToDatabase( Database::LOCALHOST.";dbname=".Database::DATABASE_NAME );
		DatabaseValidator::createTables( $connection );
	}

	private static function connectToDatabase( String $database ) : PDO
	{
		try
		{
			$connection = new PDO( $database, Database::ROOT );
			$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

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
			DatabaseValidator::queryDatabase( $connection, DatabaseValidator::$_DATABASE_COMMAND );
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );
		}
	}

	private static function createTables( PDO &$connection ) : void
	{
		foreach( DatabaseValidator::$_TABLE_COMMANDS as $command )
		{
			try
			{
				DatabaseValidator::queryDatabase( $connection, $command );
			}
			catch( PDOException $e )
			{
				echo( $e->getMessage()."<br>" );
			}
		}
	}

	private static function queryDatabase( PDO $connection, String $query, array $options = [] ) : void
	{
		$statement = $connection->prepare( $query, $options );
		$statement->execute();

		echo( "Query ($query) executed successfully<br>" );
	}
}
?>