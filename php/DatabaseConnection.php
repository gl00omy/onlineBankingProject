<?php declare( strict_types=1 );

include "QueryResult.php";

class DatabaseConnection
{
	private static String $_LOCALHOST = "mysql:host=localhost";
	private static String $username = "root";
	private String $databaseName;

	private PDO $connection;

	public function __construct( String $name )
	{
		$this->databaseName = $name;
		$this->connect( $name );
	}

	public function __destruct()
	{
		$this->connection = null;
	}

	private function constructDatabaseName( $name ) : String
	{
		if( $name === null )
		{
			return DatabaseConnection::$_LOCALHOST;
		}
		else
		{
			return DatabaseConnection::$_LOCALHOST.";dbname=$name";
		};
	}

	private function connect( ?String $databaseName ) : void
	{
		try
		{
			$database = $this->constructDatabaseName( $databaseName );

			$this->connection = new PDO( $database, DatabaseConnection::$username, null );

			$this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			echo( "Connected successfully"."<br>" );
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );

			$this->connect( null );

			$this->executeCommand( "CREATE DATABASE $this->databaseName" );

			$this->connect( $database );
		}
	}

	public function executeCommand( String $command, array $options = [] ) : int
	{
		try
		{
			$stmt = $this->connection->prepare( $command, $options );
			$stmt->execute();

			echo( "Query ($command) executed successfully"."<br>" );
			
			return $stmt->rowCount();
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage() );
		}
	}

	public function queryDatabase( String $query, array $options = [] ) : QueryResult
	{
		try
		{
			$stmt = $this->connection->prepare( $query, $options );
			$stmt->execute();

			echo( "Query ($query) executed successfully"."<br>" );
			
			return new QueryResult( $stmt );
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage() );
		}
	}
}
?>