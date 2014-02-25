<?php

header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
require 'db_connect.php';

/*
 * This class contains methods that can execute a SQL statement to the MySQL database.
 * A PDO database connection object is used for extra security over a traditional MySQL connection.
 * Furthermore, prepared statements are used - SQL queries are dynamically generated and value-binded
 * here on the server-side, and then executed to the database.
 */
class Query extends DB
{
	
	/*
	 * This method takes in certain given data parameters from the client-side JavaScript via AJAX.
 	 * These are then used to dynamically construct and execute a SQL query to the MySQL database.
 	 * The result is then returned to the client-side JavaScript and HTML via AJAX.
	 */
	public static function execSql($action, $query, $params)
	{
		try
		{
			$result = array('outcome' => 0, 'response' => "default"); // Initialise the result array.
			$pdo = parent::connectMySql();
			$stmt = $pdo->prepare($query);
			self::bindSqlParams($stmt, $params);
			// A check that produces a warning in case the SQL statement fails to execute properly.
			if (!$stmt->execute())
			{
				$result['outcome'] = 0;
				$result['response'] = 201;
				return $result;
			}
			$pdo = null; // Reset the PDO object.
			// If attempting to read from the database, need to output a result set.
			if ($action === 2)
			{
				// A check that produces a warning in case nothing was returned from the database.
				if ($stmt->rowCount() === 0)
				{
					$result['outcome'] = 0;
					$result['response'] = 202;
					return $result;
				}
				else
				{
					$result['outcome'] = 1;
					$result['response'] = $stmt->fetch(PDO::FETCH_OBJ);
					return $result;
				}
			}
			else
			{
				$result['outcome'] = 1;
				$result['response'] = 200;
				return $result;
			}
		}
		catch (PDOException $e)
		{
			$result['outcome'] = 0;
			$result['response'] = 203;
			return $result;
		}
	}

	/*
	 * This function dynamically binds the values received from Ajax to the constructed query.
	 */
	private function bindSqlParams($stmt, $params)
	{
		foreach ($params as $x => $x_value)
		{
			if (is_numeric($x_value))
			{
				$stmt->bindValue(':' . $x, $x_value, PDO::PARAM_INT);
			}
			elseif (is_string($x_value))
			{
				$stmt->bindValue(':' . $x, $x_value, PDO::PARAM_STR);
			}
			else
			{
				$stmt->bindValue(':' . $x, $x_value);
			}
		}
	}

}

/*
 * Start the process of constructing and executing a SQL query given the necessary parameters.
 */
function query($action, $query, $params)
{
	return Query::execSql($action, $query, $params);
}

?>