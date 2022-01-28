<?php declare( strict_types=1 );

require "Table.php";
require "Database.php";
require "ReturnCodes.php";
require "Queries.php";

class DatabaseConnection implements Database, ReturnCodes, Queries
{
	const EMAIL = "email";
	const PASSWORD = "password";

	private String $databaseName;
	private PDO $connection;
	private PDOStatement $statement;

	public function __construct( String $name )
	{
		$this->databaseName = Database::LOCALHOST.";dbname=$name";
		$this->connect();
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
		foreach( $this->statement->fetchAll( PDO::FETCH_ASSOC ) as $key => $row )
		{
			foreach( $row as $columnName => $field )
			{
				return $field;
			}
		}
	}

	public function getStatement() : PDOStatement
	{
		return $this->statement;
	}

	private function connect() : void
	{
		try
		{
			$this->connection = new PDO( $this->databaseName, Database::ROOT );
			$this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			echo( "Connected successfully<br>" );
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );
		}
	}

	public function queryDatabase( String $query, array $options = [] ) : void
	{
		try
		{
			$this->statement = $this->prepare( $query, $options );
			$this->statement->execute();

			echo( "Query ($query) executed successfully<br>" );
		}
		catch( PDOException $e )
		{
			echo( $e->getMessage()."<br>" );
		}
	}

	public function insertAccount( String $firstName, String $lastName, String $email, String $password ) : int
	{
		$this->queryDatabase( "SELECT id FROM ".Database::TABLE_ACCOUNTS." WHERE email = '$email'" );

		if( $this->getAffectedRows() == 0 )
		{
			$this->queryDatabase
			(
				"INSERT INTO ".Database::TABLE_ACCOUNTS." (firstname, lastname, email, password)
				VALUES ('$firstName', '$lastName', '$email', '$password')"
			);

			return self::SIGNIN_ACCOUNT_SUCCESS;
		}
		else
		{
			return self::SIGNIN_ACCOUNT_ALREADY_EXISTS;
		}
	}

	public function checkLoginCredentials( String $email, String $password ) : int
	{
		if( $this->isLoginCredentialCorrect( self::EMAIL, $email ) )
		{
			if( $this->isLoginCredentialCorrect( self::PASSWORD, $password ) )
			{
				return self::LOGIN_PASSWORD_CORRECT;
			}
			else
			{
				return self::LOGIN_PASSWORD_WRONG;
			}
		}
		else
		{
			return self::LOGIN_EMAIL_WRONG;
		}
	}

	private function isLoginCredentialCorrect( String $credentialToTest, String $credential ) : bool
	{
		$this->queryDatabase( "SELECT id FROM ".Database::TABLE_ACCOUNTS." WHERE $credentialToTest = '$credential'" );

		return boolval( $this->getAffectedRows() );
	}

	private function getOrdering 
	(
		String $amountOrdering = self::AMOUNT_ASC,
		String $dateOrdering = self::DATE_ASC
	) : String
	{
		return "ORDER BY $amountOrdering, $dateOrdering";
	}

	public function getIncomingTransactions
	(
		int $currentLoginId,
		String $amountOrder = self::AMOUNT_ASC,
		String $dateOrder = self::DATE_ASC
	) : int
	{
		$this->queryDatabase
		(
			"SELECT ".
				Database::TABLE_ACCOUNTS.".email, ".
				Database::TABLE_TRANSACTIONS.".amount, ".
				Database::TABLE_TRANSACTIONS.".excecution_date, ".
				Database::TABLE_TRANSACTIONS.".message
			FROM ".
				Database::TABLE_TRANSACTIONS."
			INNER JOIN ".
				Database::TABLE_ACCOUNTS."
			ON ".
				Database::TABLE_TRANSACTIONS.".sender_id=.".Database::TABLE_ACCOUNTS.".id
			WHERE ".
				Database::TABLE_TRANSACTIONS.".recipient_id='$currentLoginId'".
			" ".$this->getOrdering( $amountOrder, $dateOrder )
		);

		if( $this->getAffectedRows() == 0 )
		{
			return self::TRANSACTION_LIST_EMPTY;
		}
		else
		{
			return self::TRANSACTION_LIST_FILLED;
		}
	}

	public function getOutGoingTransactions
	(
		int $currentLoginId,
		String $amountOrder = self::AMOUNT_ASC,
		String $dateOrder = self::DATE_ASC
	) : int
	{
		$this->queryDatabase
		(
			"SELECT ".
				Database::TABLE_ACCOUNTS.".email, ".
				Database::TABLE_TRANSACTIONS.".amount, ".
				Database::TABLE_TRANSACTIONS.".excecution_date, ".
				Database::TABLE_TRANSACTIONS.".message
			FROM ".
				Database::TABLE_TRANSACTIONS."
			INNER JOIN ".
				Database::TABLE_ACCOUNTS."
			ON ".
				Database::TABLE_TRANSACTIONS.".recipient_id=.".Database::TABLE_ACCOUNTS.".id
			WHERE ".
				Database::TABLE_TRANSACTIONS.".sender_id='$currentLoginId'".
			" ".$this->getOrdering( $amountOrder, $dateOrder )
		);

		if( $this->getAffectedRows() == 0 )
		{
			return self::TRANSACTION_LIST_EMPTY;
		}
		else
		{
			return self::TRANSACTION_LIST_FILLED;
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
}
?>