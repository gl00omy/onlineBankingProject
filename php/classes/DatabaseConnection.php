<?php declare( strict_types=1 );

require "Table.php";
require "Database.php";
require "ReturnCodes.php";

class DatabaseConnection implements Database, ReturnCodes
{
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

			return self::SIGNIN_ACCOUNT_REGIST_SUCCESS;
		}
		else
		{
			return self::SIGNIN_ACCOUNT_ALREADY_EXISTS;
		}
	}

	public function checkLoginCredentials( String $email, String $password ) : int
	{
		if( $this->isLoginEmailCorrect( $email ) )
		{
			if( $this->isLoginPasswordCorrect( $password ) )
			{
				return self::LOGIN_PASSWORD_SUCCESS;
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

	private function isLoginEmailCorrect( String $email ) : bool
	{
		$this->queryDatabase( "SELECT id FROM ".Database::TABLE_ACCOUNTS." WHERE email = '$email'" );

		return boolval( $this->getAffectedRows() );
	}

	private function isLoginPasswordCorrect( String $password ) : bool
	{
		$this->queryDatabase( "SELECT id FROM ".Database::TABLE_ACCOUNTS." WHERE password = '$password'" );

		return boolval( $this->getAffectedRows() );
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