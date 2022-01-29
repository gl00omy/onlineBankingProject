<?php

require "php/classes/DatabaseConnection.php";

try
{
	$connection = new DatabaseConnection( Database::DATABASE_NAME );

	echo( "Connected successfully<br>" );
}
catch( PDOException $e )
{
	echo( $e->getMessage()."<br>" );
}

?>