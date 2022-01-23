<?php declare( strict_types=1 );

include "Table.php";

class QueryResult
{
	private Table $table;
	private int $affectedRows;

	public function __construct( PDOStatement $statement )
	{
		$result = $statement->fetchAll( PDO::FETCH_ASSOC );

		echo( "result leght: ".count( $result )."<br>" );
	
		if( $result == null )
		{
			$this->table = null;
		}
		else
		{
			$this->table = new Table( $result );
		}

		$this->affectedRows = $statement->rowCount();
	}

	public function getTable() : Table
	{
		return $this->table;
	}

	public function getAffectedRows() : int
	{
		return $this->affectedRows;
	}
}

?>