<?php declare( strict_types=1 );

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

	public function getAffectedRows() : int
	{
		return $this->statement->rowCount();
	}

	public function getTable() : Table
	{
		return new Table( $this->statement->fetchAll( PDO::FETCH_ASSOC ) );
	}

	public function getLoginId() : int
	{
		return $this->statement->fetchColumn();
	}

	public function getStatement() : PDOStatement
	{
		return $this->statement;
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
		$sourceId = "";
		$destinationId = "";
		$currentLoginId = $_SESSION[ "loginId" ];

		$this->setOrderingMode( $typeOfTransaction, $sourceId, $destinationId );
		
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
			return ReturnCodes::TRANSACTION_LIST_FILLED;
		}
		else
		{
			return ReturnCodes::TRANSACTION_LIST_EMPTY;
		}
	}

	private function setOrderingMode( String $typeOfTransaction, String &$sourceId, String &$destinationId ) : void
	{
		switch( $typeOfTransaction )
		{
			case Queries::INCOMING:
				$sourceId = Database::SENDER_ID_COLUMN;
				$destinationId = Database::RECIPIENT_ID_COLUMN;
				break;

			case Queries::OUTCOMING:
				$sourceId = Database::RECIPIENT_ID_COLUMN;
				$destinationId = Database::SENDER_ID_COLUMN;
				break;
		}
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
}

?>