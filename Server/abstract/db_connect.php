<?php

/*
 * This class establishes a connection to the MySQL database.
 */
abstract class DB {

	/*
	 * This is the the function responsible for connecting with database.
	 * It returns a PDO object of the database connection.
	 */
	protected function connectMySql() {
		require_once __DIR__ . '/db_config.php';

		$dsn = DSN;
		$user = DB_USER;
		$password = DB_PASSWORD;
		
		try {
			$pdoLink = new PDO($dsn, $user, $password);
		}
		catch (PDOException $e) {
			echo "Connection Failed :: " . $e->getMessage();
			return false;
		}
		return $pdoLink;
	}

}

?>