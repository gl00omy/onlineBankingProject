<?php

interface Database
{
	const LOCALHOST = "mysql:host=localhost";
	const ROOT = "root";
	const DATABASE_NAME = "OnlineBanking";
	const TABLE_ACCOUNTS = "Accounts";
	const TABLE_TRANSACTIONS = "Transactions";

	const EMAIL = "email";
	const PASSWORD = "password";
	
	const SENDER_ID_COLUMN = "sender_id";
	const RECIPIENT_ID_COLUMN = "recipient_id";
}

?>