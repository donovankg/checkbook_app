<?php
/**
* Model class for transactions in the checkbook
* 
* Note that when the user enters a date, it must be in mm/dd/yyyy format.
* But MySql requires it to be yyyy-mm-dd format
* 
* @author Niall Kader
*/

class Transaction {

	/**
    * @var int 		$id         The id of the tranaction in the DB
   	* @var string 	$date 		The date of the transaction
   	* @var number 	$amount 	The amount of the transaction
   	* @var int 		$transaction_category_id 	The id of the trans category
   	* @var string 	$notes 		Any notes that might descript the transaction
    */

	public $id = 0;
	public $date = "";
	public $amount = "";
	public $transaction_category_id = "";
	public $notes = "";

	/**
	* Validates the data set on 'this' instance of a Transaction
	*
	* @return array|true  	Returns an array that includes validation messages
	*						for each property that is not valid. Returns true if
	*						if the Transaction is valid
	*/
	function is_valid(){
		
		// Populate this array with error messages, if there are any
		$errs = array();

		// validate id - NOTE THAT 0 is a valid id, allows for inserts
		if(is_numeric($this->id) !== true || $this->id < 0){
			$errs['id'] = "ID is not valid";
		}

		// validate date
		// TODO: We will eventually want to allow m/d/Y
		// but for now we'll just go with what mysql wants Y-m-d
		
		if(DateTime::createFromFormat('m/d/Y', $this->date) === false){
		//if(DateTime::createFromFormat('Y-m-d', $this->date) === false){
			$errs['date'] = "The date is not valid";
		}
		
		// validate amount
		if(preg_match("/^[0-9]+(?:\.[0-9]{1,2})?$/", $this->amount) == false){
			$errs['amount'] = "The amount is not valid";
		}

		// validate transaction_category_id
		if(is_numeric($this->transaction_category_id) !== true || $this->transaction_category_id < 0){
			$errs['transaction_category_id'] = "Category ID is not valid";
		}

		// if the errs array is empty then the Transaction is valid
		// if not, then return it
		if(empty($errs)){
			return true;
		}else{
			return $errs;
		}
	}
}
