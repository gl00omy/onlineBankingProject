<?php

require "php/classes/DatabaseConnection.php";

try
{
	$connection = new DatabaseConnection( Database::DATABASE_NAME );
}
catch( PDOException $e )
{
	echo( $e->getMessage()."<br>" );
}

?>