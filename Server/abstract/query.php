<?php

// Enable CORS (Cross Origin Resource Sharing) - CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';

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
	public static function execSql($sqlParams, $dataParams)
	{
		try
		{
			$pdo = parent::connectMySql();
			$query = self::constructSqlQuery($sqlParams);
			$stmt = $pdo->prepare($query);
			self::bindSqlParams($stmt, $dataParams);
			// A check that produces a warning in case the SQL statement fails to execute properly.
			if (!$stmt->execute())
			{
				return "Query could not be executed!";
			}
			// If attempting to read from the database, need to output a result set.
			reset($sqlParams);
			if (key($sqlParams) === 'SELECT')
			{
				// A check that produces a warning in case nothing was returned from the database.
				if ($stmt->rowCount() == 0)
				{
					return "There is no record associated with the given id.";
				}
				$result = $stmt->fetch(PDO::FETCH_OBJ)->password; // Assign the query result set.
			}
			else
			{
				$result = "Transaction was successful!";
			}
			$pdo = null; // Reset the PDO object.
			return $result;
		}
		catch (PDOException $e)
		{
			return "Error: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * This function dynamically constructs a SQL query based on parameters received from the client-side.
	 */
	private function constructSqlQuery($sqlParams)
	{
		$query = ""; // Initilaise an empty string to hold the query.
		foreach ($sqlParams as $x => $x_value)
		{
			$query .= $x . ' '; // For each of the given SQL clauses, construct and add these to the query.
			if ($x === 'INSERT INTO'
				or $x === 'SELECT'
				or $x === 'FROM'
				or $x === 'UPDATE'
				or $x === 'DELETE FROM'
				or $x === 'SET')
			{
				foreach ($x_value as $y)
				{
					// Insert a separator between each argument.
					if ($y !== reset($x_value))
					{
	    				$query .= ', ';
					}
					// Insert the argument.
					if ($x === 'SET')
					{
						$query .= $y . ' = :' . $y;
					}
					else
					{
						$query .= $y;
					}
				}
			}
			// The 'WHERE' SQL clause requires an associative array, so use a
			// separate algorithm to construct the query.
			elseif ($x === 'WHERE')
			{
				foreach ($x_value as $y => $y_value)
				{
					// Insert a separator between each argument.
					if ($y_value !== reset($x_value))
					{
						$query .= ' ' . $y_value . ' ';
					}
					// Insert the argument.
					$query .= $y . ' = :' . $y;
				}
			}
			// Add a whitespace in-between each of the SQL clauses.
			if ($x_value !== end($sqlParams))
			{
				$query .= ' ';
			}
		}
		return $query;
	}

	/*
	 * This function dynamically binds the values received from Ajax to the constructed query.
	 */
	private function bindSqlParams($stmt, $dataParams)
	{
		try {
			foreach ($dataParams as $x => $x_value)
			{
				if (is_numeric($x_value))
				{
					$stmt->bindValue(':' . $x, $x_value, PDO::PARAM_INT);
				}
				elseif (is_string($x_value))
				{
					$stmt->bindValue(':' . $x, $x_value, PDO::PARAM_STR);
				}
			}
		}
		catch (PDOException $e)
		{
			return "Error: " . $e->getMessage() . "<br/>";
		}
	}

}

// Output the result of the executed query operation.
echo json_encode( Query::execSql( $_POST['sqlParams'], $_POST['dataParams'] ) );

?>