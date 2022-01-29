<!-- this file is meant for debugging, DELETE BEFORE SUBMISSION -->
<?php

$connection->queryDatabase( "SELECT email, password FROM ".Database::TABLE_ACCOUNTS );
$table = $connection->getTable();

echo( $table->getFull() );
echo( "affected rows: ".$connection->getAffectedRows() );

?>