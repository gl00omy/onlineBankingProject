<?php declare( strict_types=1 );

if( $_SERVER[ "REQUEST_METHOD" ] == "POST" )
{
	if( !empty( $_POST[ "email" ] ) && !empty( $_POST[ "password" ] ) )
	{
		require "php/classes/DatabaseConnection.php";
	
		$connection = new DatabaseConnection( Database::DATABASE_NAME );
	
		$result = $connection->checkLoginCredentials( $_POST[ "email" ], $_POST[ "password" ] );

		switch( $result )
		{
			case ReturnCodes::LOGIN_EMAIL_WRONG:
				echo( "<script> alert( 'Email address is not correct' ) </script>" );
				break;

			case ReturnCodes::LOGIN_PASSWORD_WRONG:
				echo( "<script> alert( 'Password is not correct' ) </script>" );
				break;

			default:
				echo
				(
					"<script>
						alert( 'Login succesfull' );
						window.location.replace( 'http://localhost/onlineBankingProject/transaction.php ');
					</script>"
				);

		}
	}
}
?>