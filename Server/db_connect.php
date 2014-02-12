<?php

/*
 * @author: Filip, Rodger, Tharman and Abdi.
 *
 * @class: This is the Abstract DB class. The purpose of this class is to connect to the database.
 */
abstract class DB {

	/*
	 * @function: This is the the function responsible for connecting with database.
	 
	 * @return: the connection link.
	 */
	public function connectMySql() {
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