<?php
/**
* This page will display all transactions in the checkbook
*
* Details about this page can go here...
*
* @author Niall Kader
*/
session_start();
// now to check if variable is true

if(!$_SESSION['anything'])
{
    header('location:login.php');
}

require_once('includes/config.inc.php');
require_once("includes/models/Transaction.php"); 
require_once('includes/dataaccess/TransactionDataAccess.php');

// get the transactions from the db
$da = new TransactionDataAccess($link);
$transactions = $da->get_all_transactions();

$page_title = "Transaction List";
require_once("includes/header.inc.php");

?>

<a href="transaction-details.php"> Create new transaction</a>
<table border="1">
	<thead>
		<th>Date</th>
		<th>Category</th>
		<th>Amount</th>
		<th>&nbsp;</th>
	</thead>
	<tbody>
	<?php
	if(!empty($transactions)){
		foreach ($transactions as $t) {
			echo("<tr>");
			echo("<td>" . $t->date . "</td>");
			echo("<td>" . $t->transaction_category_id . "</td>");
			echo("<td>" . $t->amount . "</td>");
			echo("<td><a href='transaction-details.php?id=" . $t->id . "'>DETAILS</a></td>");
			echo("</tr>");
		}
	}else{
		echo("<tr><td colspan='4' align='center'>NO TRANACTIONS</td></tr>");
	}
	?>
	</tbody>
</table>

<?php
require_once("includes/footer.inc.php");

?>