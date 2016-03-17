<?php
/**
* Handles all database queries for the app/site
* 
* Details about this class go here...
* Note that we are not importing the Transaction class. I guess
* it's assumed that the web page will do the import, maybe we need
* to look into 'autoloading'
* 
* @author Niall Kader
*/


class TransactionDataAccess{

	private $link;

	/**
	 * Constructor
	 *
	 * @param connection $link 	The link the the database 		
	 */
	function TransactionDataAccess($link){
		$this->link = $link;
	}

	/**
	* Gets all tranactions
	*
	* @return Transaction[] 	Returns an array of transaction rows
	*/
	function get_all_transactions(){
		//$qStr = "SELECT id, date, amount, transaction_category_id, notes FROM transactions";
		$qStr = "SELECT id, DATE_FORMAT(date, '%m/%d/%Y') as date, amount, transaction_category_id, notes FROM transactions";
		$result = mysqli_query($this->link, $qStr);
		//die(mysqli_error($this->link)); // THIS WILL SAVE YOUR LIFE IN DEBUGGING!!!

		$transactions = array();
		
		while($row = mysqli_fetch_array($result)){
			
			// scrub the data before adding it to the transaction
			$t = new Transaction();
			$t->id = $row['id'];
			$t->date = $row['date'];
			$t->amount = $row['amount'];
			$t->transaction_category_id = $row['transaction_category_id'];
			$t->notes = htmlentities($row['notes']);
			
			$transactions[] = $t;
		}
		
		return $transactions;
		
	}

	/**
	 * Retreives a transaction given it's id
	 *
	 * @param int|string $id 	The id of the transaction to fetch
	 *
	 * @return array|null 		An assoc array with the data for a transaction
	 */
	function get_transaction_by_id($id){
		$qStr = "SELECT id, DATE_FORMAT(date, '%m/%d/%Y') as date, amount, transaction_category_id, notes FROM transactions WHERE id = " . mysqli_real_escape_string($this->link, $id);

		//die($qStr);
		
		$result = mysqli_query($this->link, $qStr);
		//die(mysqli_error($this->link)); // THIS WILL SAVE YOUR LIFE IN DEBUGGING!!!

		if(mysqli_num_rows($result) !== 1){
			// we have a problem
			// report error
			return null;
		}

		$row = mysqli_fetch_assoc($result);

		// scrub the data
		$t = new Transaction();
		$t->id = $row['id'];
		$t->date = $row['date'];
		$t->amount = $row['amount'];
		$t->transaction_category_id = $row['transaction_category_id'];
		$t->notes = htmlentities($row['notes']);

		return $t;
	}

	function get_transaction_categories_for_selectbox(){
		//$qStr = "SELECT id, name FROM transaction_categories";
		  $qStr = "SELECT id, CONCAT(name, '( ', type, ')') as name FROM transaction_categories";
		//die($qStr);
		
		$result = mysqli_query($this->link, $qStr);
		//die(mysqli_error($this->link)); // THIS WILL SAVE YOUR LIFE IN DEBUGGING!!!

		$categories = array();
		while($row = mysqli_fetch_array($result)){
			//echo($row['id'] . ":" . $row['name'] . "<br>");
			$categories[] = array(
				'value' => $row['id'],
				'text' => htmlentities($row['name'])
				);
		}
	return $categories;
	}
	/**
	* Inserts a transaction into the database.
	*
	* @param Transaction $transaction
	*
	* @return Transaction|false 	Returns the transaction object (with the insert id)
	*								or false if the insert does not succeed.
	*/
	function insert_transaction($transaction){
		
		// we need to escape the transaction notes:
		$escaped_notes = mysqli_escape_string($this->link, $transaction->notes);

		// we also need to format the date for MySQL yyyy-mm-dd
		$formatted_date = date( 'Y-m-d', strtotime($transaction->date));

		$qStr = "INSERT INTO transactions (
					date,
					amount,
					transaction_category_id,
					notes
				) VALUES (
					'$formatted_date',
					$transaction->amount,
					$transaction->transaction_category_id,
					'$escaped_notes'
				)";

		//die($qStr);
		
		if(mysqli_query($this->link, $qStr)){
			$transaction->id = mysqli_insert_id($this->link);
			return $transaction;
		}else{
			//die(mysqli_error($this->link));
			return false;
		}
	}

	/**
	* Updates a transaction in the database.
	*
	* @param Transaction $transaction
	*
	* @return Transaction|false 	Returns the transaction object (with the insert id)
	*								or false if the insert does not succeed.
	*/
	function update_transaction($transaction){
		
		// we need to escape the transaction notes:
		$escaped_notes = mysqli_escape_string($this->link, $transaction->notes);

		// we also need to format the date for MySQL yyyy-mm-dd
		$formatted_date = date('Y-m-d', strtotime($transaction->date));

		$qStr = "UPDATE transactions SET
					date = '$formatted_date',
					amount = $transaction->amount,
					transaction_category_id = $transaction->transaction_category_id,
					notes = '$escaped_notes'
				WHERE id = $transaction->id";
				
		//die($qStr);
		
		if(mysqli_query($this->link, $qStr)){
			$transaction->id = mysqli_insert_id($this->link);
			return $transaction;
		}else{
			//die(mysqli_error($this->link));
			return false;
		}
	}
}