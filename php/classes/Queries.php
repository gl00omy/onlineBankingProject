<?php

interface Queries
{
	const INCOMING = "incoming";
	const OUTCOMING = "outcoming";

	const AMOUNT_ASC = "amount ASC";
	const AMOUNT_DESC = "amount DESC";

	const DATE_ASC = "excecution_date ASC";
	const DATE_DESC = "excecution_date DESC";

	const DROPDOWN_AMOUNT_ASC = "amountAscending";
	const DROPDOWN_AMOUNT_DESC = "amountDescending";

	const DROPDOWN_DATE_ASC = "dateAscending";
	const DROPDOWN_DATE_DESC = "dateDescending";

	const ADD = "+";
	const SUBTRACT = "-";
}

/* 
require "Table.php";
require "Database.php";
require "ReturnCodes.php";
require "Queries.php";

class DatabaseConnection implements Database, ReturnCodes, Queries
{
	private PDO $connection;
	private PDOStatement $statement;

	public function __construct( String $name )
	{
		$this->connection = new PDO( Database::LOCALHOST.";dbname=$name", Database::ROOT );
		$this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}

	public function __destruct()
	{
		$this->connection = null;
	}

	public function getStatement() : PDOStatement
	{
		return $this->statement;
	}

	public function getTable() : Table
	{
		return new Table( $this->statement->fetchAll( PDO::FETCH_ASSOC ) );
	}

	public function getAffectedRows() : int
	{
		return $this->statement->rowCount();
	}

	public function getSelectedValue() : int
	{
		return $this->statement->fetchColumn();
	}

	public function queryDatabase( String $query, array $options = [] ) : void
	{
		try
		{
			$this->statement = $this->prepare( $query, $options );
			$this->statement->execute();
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );
		}
	}

	public function insertAccount( String $firstName, String $lastName, String $email, String $password ) : int
	{
		if( !$this->isCredentialPresent( Database::EMAIL, $email ) )
		{
			$this->queryDatabase
			(
				"INSERT INTO ".Database::TABLE_ACCOUNTS." (firstname, lastname, email, password)
				VALUES ('$firstName', '$lastName', '$email', '$password')"
			);

			return ReturnCodes::SIGNIN_ACCOUNT_SUCCESS;
		}
		else
		{
			return ReturnCodes::SIGNIN_ACCOUNT_ALREADY_EXISTS;
		}
	}

	public function checkLoginCredentials( String $email, String $password ) : int
	{
		if( $this->isCredentialPresent( Database::EMAIL, $email ) )
		{
			if( $this->isCredentialPresent( Database::PASSWORD, $password ) )
			{
				return ReturnCodes::LOGIN_PASSWORD_CORRECT;
			}
			else
			{
				return ReturnCodes::LOGIN_PASSWORD_WRONG;
			}
		}
		else
		{
			return ReturnCodes::LOGIN_EMAIL_WRONG;
		}
	}

	private function isCredentialPresent( String $credentialToTest, String $credential ) : bool
	{
		$this->queryDatabase( "SELECT id FROM ".Database::TABLE_ACCOUNTS." WHERE $credentialToTest = '$credential'" );

		return $this->queryFoundResults();
	}

	public function getTransactions( String $typeOfTransaction, String $amountOrdering, String $dateOrdering ) : int
	{
		$currentLoginId = $_SESSION[ "loginId" ];

		$sourceId = ($typeOfTransaction == Queries::INCOMING ) ? Database::SENDER_ID : Database::RECIPIENT_ID;
		$destinationId = ($typeOfTransaction == Queries::OUTCOMING ) ? Database::SENDER_ID : Database::RECIPIENT_ID;
		
		$this->queryDatabase
		(
			"SELECT ".
				Database::TABLE_ACCOUNTS.		".email, ".
				Database::TABLE_TRANSACTIONS.	".amount, ".
				Database::TABLE_TRANSACTIONS.	".excecution_date, ".
				Database::TABLE_TRANSACTIONS.	".message

			FROM ".Database::TABLE_TRANSACTIONS."

			INNER JOIN ".Database::TABLE_ACCOUNTS."

			ON ".Database::TABLE_TRANSACTIONS.".$sourceId=.".Database::TABLE_ACCOUNTS.".id

			WHERE ".Database::TABLE_TRANSACTIONS.".$destinationId='$currentLoginId'

			ORDER BY $amountOrdering, $dateOrdering"
		);

		if( $this->queryFoundResults() )
		{
			return ReturnCodes::TRANSACTION_TABLE_FILLED;
		}
		else
		{
			return ReturnCodes::TRANSACTION_TABLE_EMPTY;
		}
	}

	public function excecuteTransaction( int $recipientId, int $amount, String $message ) : int
	{
		$currentLoginId = $_SESSION[ "loginId" ];

		if( $recipientId === $currentLoginId )
		{
			return ReturnCodes::TRANSACTION_RECIPIENT_SELF;
		}
		else if( !$this->isTransactionRecipientPresent( $recipientId ) )
		{
			return ReturnCodes::TRANSACTION_RECIPIENT_NOT_FOUND;
		}
		else
		{
			return $this->checkTransactionAmount( $currentLoginId, $recipientId, $amount, $message );
		}
	}

	private function isTransactionRecipientPresent( int $id ) : bool
	{
		$this->queryDatabase( "SELECT recipient_id FROM ".Database::TABLE_TRANSACTIONS );

		return $this->queryFoundResults();
	}

	private function checkTransactionAmount( int $currentLoginId, int $recipientId, int $amount, String $message ) : int
	{
		switch( $this->checkAccountBalance( $currentLoginId, $amount ) )
		{
			case ReturnCodes::INSUFFICIENT_BALANCE:
				return ReturnCodes::TRANSACTION_AMOUNT_LIMIT_OVER;

			case ReturnCodes::EMPTY_BALANCE_AFTER_TRANSACTION:
				return ReturnCodes::TRANSACTION_AMOUNT_LIMIT_EQUAL;

			case ReturnCodes::SUFFICIENT_BALANCE:
				$this->updateAccountBalance( Queries::SUBTRACT, $amount, $currentLoginId );
				$this->updateAccountBalance( Queries::ADD, $amount, $recipientId );
				$this->addTransactionToTable( $currentLoginId, $recipientId, $amount, $message );
				
				return ReturnCodes::TRANSACTION_AMOUNT_SUCCESS;
		}
	}

	private function checkAccountBalance( int $currentLoginId, int $amount ) : int
	{
		$this->queryDatabase( "SELECT balance FROM ".Database::TABLE_ACCOUNTS." WHERE id = '$currentLoginId'" );
		$balance = $this->getSelectedValue();

		return $balance <=> $amount;
	}

	private function updateAccountBalance( String $operation, int $amount, int $id ) : void
	{
		$this->queryDatabase
		(
			"UPDATE ".Database::TABLE_ACCOUNTS."

			SET balance = balance $operation $amount"."

			WHERE id = '$id'"
		);
	}

	private function addTransactionToTable( int $senderId, int $recipientId, int $amount, String $message ) : void
	{
		$this->queryDatabase
		(
			"INSERT INTO ".Database::TABLE_TRANSACTIONS." (sender_id, recipient_id, amount, message)"."
			
			VALUES ($senderId, $recipientId, $amount, '$message')"
		);
	}

	public function prepare( String $query, array $option = [] ) : PDOStatement
	{
		return $this->connection->prepare( $query, $option );
	}

	public function rollback() : bool
	{
		return $this->connection->rollBack();
	}

	private function queryFoundResults() : bool
	{
		return boolval( $this->getAffectedRows() );
	}
} */
?>