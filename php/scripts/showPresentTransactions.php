<?php declare( strict_types=1 );

require "php/classes/DatabaseConnection.php";

$connection = new DatabaseConnection( Database::DATABASE_NAME );

$connection->queryDatabase( "SELECT * FROM ".Database::TABLE_TRANSACTIONS );
$table = $connection->getTable();

echo( $table->getFullTable() );
echo( "affected rows: ".$connection->getAffectedRows() );
?>