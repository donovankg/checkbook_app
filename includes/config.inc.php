<?php
/**
* This is the master configuration file for this website
*
* Details of the file go here
*
* @author Niall Kader
*/

/**
* The root directory of this website
*/
$root_dir;

/**
* Database connection details
*/
$host;
$db;
$user;
$password;
$link;

/**
* Set up configuration base on the environment
*/
if($_SERVER['SERVER_NAME'] == "localhost"){
	// DEV ENVIRONMENT SETTINGS
	error_reporting(E_ALL);  // turn on all error reporting
	$host = "localhost";
	$db = "sample_db";
	$user = "root";
	$password = "";
	$root_dir = "/checkbook/";
}else{
	// PRODUCTION SETTINGS
	$host = "???";
	$db = "???";
	$user = "???";
	$password = "???";
	$root_dir = "/";
}

// set up a connection to the db
$link = mysqli_connect($host, $user, $password, $db);
