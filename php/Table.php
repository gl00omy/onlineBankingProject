<?php declare( strict_types=1 );

class Table
{
	private String $fullTable;
	private String $headersTable;
	private String $valuesTable;

	public function __construct( array $result )
	{
		$this->createFullTable( $result );
		$this->createHeadersTable( $result );
		$this->createValuesTable( $result );
	}

	public function getFullTable() : String
	{
		return $this->fullTable;
	}

	public function getHeadersTable() : String
	{
		return $this->headersTable;
	}

	public function getValuesTable() : String
	{
		return $this->valuesTable;
	}

	private function createFullTable( array &$result ) : void
	{
		$this->fullTable = "<table style='border: solid 1px black;'>";

		$this->createHeaderRow( $this->fullTable, $result[ 0 ] );

		foreach( $result as $key => $row )
		{
			$this->createValuesRow( $this->fullTable, $row );
		}

		$this->fullTable .= "</table>";
	}

	private function createHeadersTable( array &$result ) : void
	{
		$this->headersTable = "<table style='border: solid 1px black;'>";

		$this->createHeaderRow( $this->headersTable, $result[ 0 ] );

		$this->headersTable .= "</table>";
	}

	private function createValuesTable( array &$result ) : void
	{
		$this->valuesTable = "<table style='border: solid 1px black;'>";

		foreach( $result as $key => $row )
		{
			$this->createValuesRow( $this->valuesTable, $row );
		}

		$this->valuesTable .= "</table>";
	}

	private function createHeaderRow( String &$table, array &$row ) : void
	{
		$table .= "<tr>";
		foreach( $row as $columnName => $field )
		{
			$table .= "<th>".$columnName."</th>";
		}
		$table .= "</tr>";
	}

	private function createValuesRow( String &$table, array $row ) : void
	{
		$table .= "<tr>";
		foreach( $row as $columnName => $field )
		{
			$table .= "<td>".$field."</td>";
		}
		$table .= "</tr>";
	}
}

?>