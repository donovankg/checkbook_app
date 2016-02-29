/**
* All of your javascript code should be namespaced so that you don't run the risk
* of name collisions. So the namespace I've used here is 'acme' but in the real world
* you would probably use your domain name for your namespace.
*
* @module acme
*/
var acme = acme || {};
// it's possible, even likely, that the 'acme' object is created in another js file
// so we check for that before we create a new object


/**
* You might add a property to the 'acme' object that contains all the validation
* code for your site
*
* @submodule acme-validation
*/
var acme.validation = acme.validation || {};
// The acme.validation object may also be created in another js file

/**
* Validates the transaction details form.
*
* @method validateTransactionDetails
* @return {boolean} 	Returns true if the form is valid, false otherwise.
*/
acme.validation.validateTransactionDetails = function(){
	// validation code for the the transaction details form could go here
};

