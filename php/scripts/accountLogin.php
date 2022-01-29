<?php declare( strict_types=1 );

if( $_SERVER[ "REQUEST_METHOD" ] === "POST" && !isInputEmpty() )
{
	$result = $connection->checkLoginCredentials( $_POST[ "email" ], $_POST[ "password" ] );

	switch( $result )
	{
		case ReturnCodes::LOGIN_EMAIL_WRONG:
			$emailErrMsg = "Email address is not correct";
			break;

		case ReturnCodes::LOGIN_PASSWORD_WRONG:
			$passwordErrMsg = "Password is not correct";
			break;

		case ReturnCodes::LOGIN_PASSWORD_CORRECT:
			$_SESSION[ "loginId" ] = $connection->getSelectedValue();

			header( "Location: http://localhost/onlineBankingProject/my_account.php", true, 301 );
			exit();

		default:
			echo( ReturnCodes::ERROR_MESSAGE );
	}
}

function isInputEmpty() : bool
{
	return empty( $_POST[ "email" ] ) || empty( $_POST[ "password" ] );
}

?>