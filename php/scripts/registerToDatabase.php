<?php declare( strict_types=1 );

if( $_SERVER[ "REQUEST_METHOD" ] == "POST" )
{
	if
	(
		!empty( $_POST[ "firstName" ] )	&&
		!empty( $_POST[ "lastName" ] )	&&
		!empty( $_POST[ "email" ] )		&&
		!empty( $_POST[ "password" ] )
	)
	{
		require "php/classes/DatabaseConnection.php";
	
		$connection = new DatabaseConnection( Database::DATABASE_NAME );
	
		$resultOfInsertion = $connection->insertAccount
		(
			$_POST[ "firstName" ],
			$_POST[ "lastName" ],
			$_POST[ "email" ],
			$_POST[ "password" ]
		);

		if( $resultOfInsertion == DatabaseConnection::INSERT_SUCCESS )
		{
			echo
			(
				"<script>
					alert( 'Account created succesfully' );
					window.location.replace( 'http://localhost/onlineBankingProject/index.php ');
				</script>"
			);
		}
		else
		{
			echo( "<script> alert( 'Account already exists' ) </script>" );
		}
	}
}
?>