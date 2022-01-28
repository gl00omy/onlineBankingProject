<?php declare( strict_types=1 );

interface ReturnCodes
{
	const ERROR_MESSAGE = "Something went wrong";

	const LOGIN_EMAIL_WRONG = 100;
	const LOGIN_EMAIL_CORRECT = 101;

	const LOGIN_PASSWORD_WRONG = 110;
	const LOGIN_PASSWORD_CORRECT = 111;

	const SIGNIN_ACCOUNT_ALREADY_EXISTS = 200;
	const SIGNIN_ACCOUNT_SUCCESS = 201;

	const TRANSACTION_LIST_EMPTY = 300;
	const TRANSACTION_LIST_FILLED = 301;
}
?>