<?php declare( strict_types=1 );

class Table
{
	private static String $openingTableTag = "<table style='border: 1px solid black;'>";
	private static String $closingTableTag = "</table>";

	private static String $openingTableRowTag = "<tr>";
	private static String $closingTableRowTag = "</tr>";

	private static String $openingTableHeaderTag = "<th>";
	private static String $closingTableHeaderTag = "</th>";

	private static String $openingTableDataTag = "<td style='width:150px; border:1px solid black;'>";
	private static String $closingTableDataTag = "</td>";

	private String $fullTable = "";

	public function __construct( array $result )
	{
		$this->createTable( $result );
	}

	public function getFull() : String
	{
		return $this->fullTable;
	}

	private function createTable( array &$result ) : void
	{
		$this->fullTable = Table::$openingTableTag;

		$this->createHeaderRow( $this->fullTable, $result[ 0 ] );

		foreach( $result as $key => $row )
		{
			$this->createValuesRow( $this->fullTable, $row );
		}

		$this->fullTable .= Table::$closingTableTag;
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