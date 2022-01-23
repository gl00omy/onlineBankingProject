<?php declare( strict_types=1 );

include "Table.php";

class DatabaseConnection
{
	private String $databaseName;

	private PDO $connection;
	private PDOStatement $statement;

	public function __construct( String $name )
	{
		$this->databaseName = $name;
		$this->connect( $name );
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

	private function connect( ?String $databaseName ) : void
	{
		try
		{
			$this->connection = new PDO
			(
				BankDatabaseValidator::$_LOCALHOST.";dbname=$databaseName",
				BankDatabaseValidator::$_ROOT,
				null,
				array( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION )
			);

			echo( "Connected successfully"."<br>" );
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

			echo( "Query ($query) executed successfully"."<br>" );
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