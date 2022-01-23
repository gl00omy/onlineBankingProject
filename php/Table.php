<?php declare( strict_types=1 );

class Table
{
	private static String $openingTableTag = "<table style='border: solid 1px black;'>";
	private static String $closingTableTag = "</table>";

	private static String $openingTableRowTag = "<tr>";
	private static String $closingTableRowTag = "</tr>";

	private static String $openingTableHeaderTag = "<th>";
	private static String $closingTableHeaderTag = "</th>";

	private static String $openingTableDataTag = "<td>";
	private static String $closingTableDataTag = "</td>";

	private String $fullTable = "";
	private String $headersTable = "";
	private String $valuesTable = "";

	public function __construct( ?array $result )
	{
		if( !is_null( $result ) )
		{
			$this->createFullTable( $result );
			$this->createHeadersTable( $result );
			$this->createValuesTable( $result );
		}
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
		$this->fullTable = Table::$openingTableTag;

		$this->createHeaderRow( $this->fullTable, $result[ 0 ] );

		foreach( $result as $key => $row )
		{
			$this->createValuesRow( $this->fullTable, $row );
		}

		$this->fullTable .= Table::$closingTableTag;
	}

	private function createHeadersTable( array &$result ) : void
	{
		$this->headersTable = Table::$openingTableTag;

		$this->createHeaderRow( $this->headersTable, $result[ 0 ] );

		$this->headersTable .= Table::$closingTableTag;
	}

	private function createValuesTable( array &$result ) : void
	{
		$this->valuesTable = Table::$openingTableTag;

		foreach( $result as $key => $row )
		{
			$this->createValuesRow( $this->valuesTable, $row );
		}

		$this->valuesTable .= Table::$closingTableTag;
	}

	private function createHeaderRow( String &$table, array &$row ) : void
	{
		$table .= Table::$openingTableRowTag;
		foreach( $row as $columnName => $field )
		{
			$table .= Table::$openingTableHeaderTag.$columnName.Table::$closingTableHeaderTag;
		}
		$table .= Table::$closingTableRowTag;
	}

	private function createValuesRow( String &$table, array $row ) : void
	{
		$table .= Table::$openingTableRowTag;
		foreach( $row as $columnName => $field )
		{
			$table .= Table::$openingTableDataTag.$field.Table::$closingTableDataTag;
		}
		$table .= Table::$closingTableRowTag;
	}
}

?>