<?php 
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'multi_login');

// variable declaration
$username     = "";
$accessno     = "";
$email        = "";
$DOB          = "";
$phoneNo      = "";
$allergies    = "";
$disabilities = "";
$blood        = "";
$residence    = "";
$NOK          = "";
$NOKRelation  = "";
$NOKPhone     = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $accessno, $email, $DOB, $phoneNo, $allergies, $disabilities, $blood, $residence, $NOK, $NOKRelation, $NOKPhone;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$accessno    =  e($_POST['accessno']);
	$email       =  e($_POST['email']);
	$DOB    =  e($_POST['DOB']);
	$phoneNo    =  e($_POST['PhoneNumber']);
	$allergies    =  e($_POST['Allergies']);
	$disabilities    =  e($_POST['Disabilities']);
	$blood    =  e($_POST['BloodGroup']);
	$residence    =  e($_POST['Residence']);
	$NOK    =  e($_POST['NextOfKin']);
	$NOKRelation    =  e($_POST['NOKrelationship']);
	$NOKPhone    =  e($_POST['NOKPhone']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, AccessNumber, email, DOB, PhoneNumber, Allergies, Disabilities, BloodGroup, Residence, NextOFKin, NOKrelationship, NOKPhone, user_type, password) 
					  VALUES('$username', '$accessno', '$email', '$DOB', '$phoneNo', '$allergies', '$disabilities', '$blood', '$residence', '$NOK', '$NOKRelation', '$NOKPhone','$user_type', '$password')";

			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		}else{
			$query = "INSERT INTO users (username, AccessNumber, email, DOB, PhoneNumber, Allergies, Disabilities, BloodGroup, Residence, NextOFKin, NOKrelationship, NOKPhone, user_type, password) 
					  VALUES('$username', '$accessno', '$email', '$DOB', '$phoneNo', '$allergies', '$disabilities', '$blood', '$residence', '$NOK', '$NOKRelation', '$NOKPhone','$user_type', '$password')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: home.php');				
		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// If the login button is clicked, the login() function is called which logs the user in
// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/home.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: home.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

// checks if the user is admin
function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}