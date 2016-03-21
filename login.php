<?php

//$utils = new Utils();
$page_title = "Login Page";
require_once("includes/header.inc.php");
require_once('includes/Utils.php');
$Utils = new Utils();


?>
<form id="frmTransactionDetails" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
	
Email address: <input type="text" name="txtEmail" id="txtEmail" />
</br>
password: <input type="text" name="txtPassword" id="txtPassword" />	
</br>
<input type="submit" name="btnSubmit" value="SUBMIT" />
	
</form>



<?php
require_once("includes/footer.inc.php");

?>
