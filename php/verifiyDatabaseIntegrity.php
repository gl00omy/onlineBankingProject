<?php declare( strict_types=1 );

include "DatabaseConnection.php";

$databaseName = "databaseTest";

$connection = new DatabaseConnection( $databaseName );

// $sql =
// (
// 	"CREATE TABLE MyGuests
// 	(
// 		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
// 		firstname VARCHAR(30) NOT NULL,
// 		lastname VARCHAR(30) NOT NULL,
// 		email VARCHAR(50),
// 		reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// 	)"
// );

$result = $connection->queryDatabase( "SELECT * FROM MyGuests" );
$table = $result->getTable();

echo( $table->getFullTable() );
echo( $table->getHeadersTable() );
echo( $table->getValuesTable() );
echo( "affected rows: ".$result->getAffectedRows()."<br>" );


$result = $connection->queryDatabase( "DELETE FROM MyGuests WHERE id=2" );
echo( "affected rows: ".$result."<br>" );

?>