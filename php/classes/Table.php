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

	public function getFull() : String
	{
		return $this->fullTable;
	}

	public function getHeaders() : String
	{
		return $this->headersTable;
	}

	public function getValues() : String
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

// <table class="table table-bordered table-striped table-hover">
// 	<thead>
// 		<tr>
// 			<th scope="col">#</th>
// 			<th scope="col">First</th>
// 			<th scope="col">Last</th>
// 			<th scope="col">Handle</th>
// 		</tr>
// 	</thead>
// 	<tbody>
// 		<tr>
// 			<th scope="row">1</th>
// 			<td>Mark</td>
// 			<td>Otto</td>
// 			<td>@mdo</td>
// 		</tr>
// 		<tr>
// 			<th scope="row">2</th>
// 			<td>Jacob</td>
// 			<td>Thornton</td>
// 			<td>@fat</td>
// 		</tr>
// 		<tr>
// 			<th scope="row">3</th>
// 			<td>Larry</td>
// 			<td>Bird</td>
// 			<td>@twitter</td>
// 		</tr>
// 	</tbody>
// </table>
?>