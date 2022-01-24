<?php declare( strict_types=1 );

require "Table.php";
require "Database.php";

class DatabaseConnection implements Database
{
	private String $databaseName;
	private PDO $connection;
	private PDOStatement $statement;

	public function __construct( String $name )
	{
		$this->databaseName = Database::LOCALHOST.";dbname=$name";
		$this->connect();
	}

	public function __destruct()
	{
		$this->connection = null;
	}

	public function getAffectedRows() : int
	{
		return $this->statement->rowCount();
	}

	public function getTable() : Table
	{
		return new Table( $this->statement->fetchAll( PDO::FETCH_ASSOC ) );
	}

	public function getStatement() : PDOStatement
	{
		return $this->statement;
	}

	private function connect() : void
	{
		try
		{
			$this->connection = new PDO( $this->databaseName, Database::ROOT );
			$this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			echo( "Connected successfully<br>" );
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );
		}
	}

	public function queryDatabase( String $query, array $options = [] ) : void
	{
		try
		{
			$this->statement = $this->prepare( $query, $options );
			$this->statement->execute();

			echo( "Query ($query) executed successfully<br>" );
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );
		}
	}

	public function prepare( String $query, array $option = [] ) : PDOStatement
	{
		return $this->connection->prepare( $query, $option );
	}

	public function rollback() : bool
	{
		return $this->connection->rollBack();
	}
}
?>