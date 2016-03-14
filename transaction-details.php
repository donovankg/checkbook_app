<?php
/**
* This page will display the details of a transaction, 
* and allow for inserting and updating transactions.
*
* Note that the user must enter dates in mm/dd/yyyy format BUT MySQL
* requires that dates are inserted as yyyy-mm-dd format.
*
* @author Niall Kader
*/

require_once('includes/config.inc.php');
require_once("includes/models/Transaction.php"); 
require_once('includes/dataaccess/TransactionDataAccess.php');
require_once('includes/models/Utils.php');
// test code
$da = new TransactionDataAccess($link);
$Utils = new Utils();
//get the sekect box options for transaction categorities
$options = $da-> get_transaction_categories_for_selectbox();




/*
// Test the validation - fill up a Transaction with bad data
$t = new Transaction();
$t->id = "x";
$t->date = "x";
$t->amount = "x";
$t->transaction_category_id = "x";
var_dump($t->is_valid());
*/

/*
// Test the validation - fill up a Transaction with good data
$t = new Transaction();
$t->id = 1;							// note that a string will not validate!
$t->date = "02/18/2016";			// this one gave me some fits
$t->amount = "7.52";
$t->transaction_category_id = 1;	// note that a string will not validate!
var_dump($t->is_valid());
*/

/*
Question - we know that the HTML form will post the id and transaction_category_id as
a string, but we've seen that if we pass in a string, it won't validate.
How do we overcome this problem?
*/


$transaction = new Transaction();

// check for the query string param
if(isset($_POST['btnSubmit'])){

	// remember that some HTML controls will not post if the user
	// does not set them, so we may need to use isset()
	$transaction->id = $_POST['txtId'];
	$transaction->date = $_POST['txtDate'];
	$transaction->amount = $_POST['txtAmount'];
	$transaction->transaction_category_id = $_POST['txtCategoryId'];
	$transaction->notes = $_POST['txtNotes'];

	if($transaction->is_valid() === true){
		die("THANK YOU, if this is a new transaction we'll insert, if it already exists, we'll update it");
		// HOW CAN WE DETERMINE IF WE NEED TO INSERT OR UPDATE???
	}else{
		$errs = $transaction->is_valid();
		var_dump($errs);
		die("<br>FOUL PLAY!!! - Log the data and send an email to the admin! OR....could there be a problem with comparing strings to numbers????");
	}

}else{
	if(isset($_GET['id'])){
		$da = new TransactionDataAccess($link);
		$transaction = $da->get_transaction_by_id($_GET['id']);
		// Note sure how to handle this if the method call does not return a
		// transaction, where should we handle this (TransactionDataAccesss???)
		if($transaction == null){
			// TODO: how to deal with this scenario???
			die("no transaction with id of: ". $_GET['id']);
		}
	}
}

?>
<link rel="stylesheet" href="<?php echo($root_dir);?>css/style.css" type="text/css" />
<script src="<?php echo($root_dir);?>js/vendor/jquery-2.2.0.min.js"></script>

<form id="frmTransactionDetails" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
	
	<input type="hidden" name="txtId" id="txtId" value="<?php echo($transaction->id); ?>" />
	
	DATE (mm/dd/yyyy): <input type="text" name="txtDate" id="txtDate" value="<?php echo($transaction->date); ?>" />
	<span class="validation" id="vDate"></span>
	<br>

	CATEGORY: <?php echo ($Utils -> create_select_box("txtCategoryId",$options, 0));?>
	<span class="validation" id="vCategoryId"></span>
	<br>
	
	AMOUNT: <input type="text" name="txtAmount" id="txtAmount" value="<?php echo($transaction->amount); ?>" />
	<span class="validation" id="vAmount"></span>
	<br>

	NOTES: <input type="text" name="txtNotes" id="txtNotes" value="<?php echo($transaction->notes); ?>" /><br>
	<input type="submit" name="btnSubmit" value="SUBMIT" />
</form>

<script>
/*
If you wanna get hard-core, there may be better ways to do this.
The problem with this approach is that it's very difficult to minify this
code. You could put it in an external .js file and then use a tool to minify
all your js code and concatenate it into one file. Then your js code will be as small
as possible, and it would take just a single request to load it all. It would then
be cached in the browser, and not have to be re-transmitted when the visitor
goes to another page on our site.
*/
jQuery(function(){

	$(document).ready(function(){

		// handles the form submit, if this method returns false
		// then the form will not post to the server
		$("#frmTransactionDetails").submit(function(){

			// set this to false if we find any errors
			var isValid = true;

			// get the data that needs to be validated
			var date = $("#txtDate").val();
			var amount = $("#txtAmount").val();
			var categoryId = $("#txtCategoryId").val();

			// clear out any error messages
			$(".validation").text("");

			// we'll put the focus on the first input control that is not valid
			var focusOn = null;

			// validate date - it should be in yyyy-mm-dd format for MySQL
			//var regExpDate = /^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/;
			var regExpDate = /^(0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])[\/\-]\d{4}$/;
			
			if(date == ""){
				$("#vDate").text("Please enter a date.");
				focusOn = focusOn || $("#txtDate");
				isValid = false;
			}else if(regExpDate.test(date) === false){
				$("#vDate").text("Date must be in mm-dd-yyyy format.");
				focusOn = focusOn || $("#txtDate");
				isValid = false;
			}

			// validate category id
			// TODO: use a select box instead of a textbox here
			if(categoryId == ""){
				$("#vCategoryId").text("Please enter a category id.");
				focusOn = focusOn || $("#txtCategoryId");
				isValid = false;
			}else if(isNaN(categoryId)){
				$("#vCategoryId").text("Category id must be a number.");
				focusOn = focusOn || $("#txtCategoryId");
				isValid = false;
			}else if(categoryId < 0){
				$("#vCategoryId").text("Category id must not be negative.");
				focusOn = focusOn || $("#txtCategoryId");
				isValid = false;
			}

			// validate amount
			if(amount == ""){
				$("#vAmount").text("Please enter an amount.");
				focusOn = focusOn || $("#txtAmount");
				isValid = false;
			}else if(isNaN(amount)){
				$("#vAmount").text("Amount must be a number.");
				focusOn = focusOn || $("#txtAmount");
				isValid = false;
			}else if(amount < 0){
				$("#vAmount").text("Amount must be a positive number.");
				focusOn = focusOn || $("#txtAmount");
				isValid = false;
			}

			focusOn.select();
			return isValid;

		});
	});
});
</script>





