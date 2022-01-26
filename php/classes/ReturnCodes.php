<?php declare( strict_types=1 );

interface ReturnCodes
{
	const SUCCESS = 1;
	const FAILURE = -1;

	const LOGIN_EMAIL_WRONG = 100;
	const LOGIN_EMAIL_CORRECT = 101;

	const LOGIN_PASSWORD_WRONG = 110;
	const LOGIN_PASSWORD_SUCCESS = 111;

	const SIGNIN_ACCOUNT_ALREADY_EXISTS = 200;
	const SIGNIN_ACCOUNT_REGIST_SUCCESS = 201;
}
?>