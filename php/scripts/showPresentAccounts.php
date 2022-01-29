<?php

// this file is meant for debugging, DELETE BEFORE SUBMISSION

$connection->queryDatabase( "SELECT id, email, password, balance FROM ".Database::TABLE_ACCOUNTS );
$table = $connection->getTable();

echo( $table->getFull() );

?>