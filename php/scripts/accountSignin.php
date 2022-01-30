<?php declare( strict_types=1 );

if( $_SERVER[ "REQUEST_METHOD" ] === "POST" && !isInputEmpty() )
{
	$result = $connection->insertAccount
	(
		$_POST[ "firstName" ],
		$_POST[ "lastName" ],
		$_POST[ "email" ],
		$_POST[ "password" ]
	);

	switch( $result )
	{
		case ReturnCodes::SIGNIN_ACCOUNT_ALREADY_EXISTS:
			$accountAlreadyExistingErrMsg = "Account already exists";
			break;

		case ReturnCodes::SIGNIN_ACCOUNT_SUCCESS:
			header( "Location: http://localhost/onlineBankingProject/index.php", true, 301 );
			exit();

		default:
			echo( ReturnCodes::ERROR_MESSAGE );
	}
}

function isInputEmpty() : bool
{
	return empty( $_POST[ "firstName" ] ) || empty( $_POST[ "lastName" ] ) ||
		empty( $_POST[ "email" ] ) || empty( $_POST[ "password" ] );
}

?>