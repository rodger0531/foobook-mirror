<?php

/*
 * Connects to the database.
 */
abstract class DB {

	/*
	 * Responsible for connecting with database.
	 * Returns the connection link as a PDO object.
	 */
	public function connectMySql()
	{
		require_once __DIR__ . '/db_config.php';

		$dsn = DSN;
		$user = DB_USER;
		$password = DB_PASSWORD;
		
		try
		{
			$pdoLink = new PDO($dsn, $user, $password);
			$pdoLink->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$pdoLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			echo "Connection Failed :: " . $e->getMessage();
			return false;
		}
		return $pdoLink;
	}

}

?>