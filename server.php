<?php

session_start();

//initializing variables

$username = "";
$email = "";
$errors = array();

include("connection.php");
// Register Users

if(isset($_POST['reg_user'])){

$username = mysqli_real_escape_string($db, $_POST['username']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

//
// $_SESSION['id'] = $userid;
// form validation


if(empty($username)){array_push($errors, "Error : Username is required");}
if(empty($email)){array_push($errors, "Error : Email is required");}
if(empty($password_1)){array_push($errors, "Error : Password is required");}
if($password_1 != $password_2){array_push($errors, "Error : Passwords do not match, Please try again.");}
if(strlen($username) < 6){array_push($errors, "Username must be minimum of 7 characters");}
if(strlen($username) > 20){array_push($errors, "Username must be maximum of 20 characters");}

$profile_pic = "images/pic1.png";
// chech db if existing user with the same username.

$user_check_query = "SELECT * FROM data WHERE username='$username' OR email='$email' LIMIT 1";

$results = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($results);

if($user){ //if user exists
  if(strtolower($user['username']) === strtolower($username)){
    array_push($errors, "Username already exists");
  }
  if(strtolower($user['email']) === strtolower($email)){
    array_push($errors, "This email is already registered");
  }
}

//Register the user if there is no error.
if(count($errors) == 0){
  $password = md5($password_1);
  $query = "INSERT INTO data (username, email, password, profile_pic) VALUES ('$username','$email','$password', '$profile_pic')";

  mysqli_query($db, $query);
  $_SESSION['username'] = $username;
  $_SESSION['success'] = "You are now logged in";
  header('location: timeline.php');
 }
}

//Login Users
if(isset($_POST['login_user'])){

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);


  if(empty($username)){array_push($errors, "Username is required");}
  if(empty($password)){array_push($errors, "Password is required");}

  if(count($errors) == 0){
    $password = md5($password);
    $query = "SELECT * FROM data WHERE username='$username' AND password='$password'";

    $results = mysqli_query($db, $query);

    if(mysqli_num_rows($results)){
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in successfully";

      header('location: timeline.php');
    }else{
      array_push($errors, "Wrong Username/Password. Please try again.");
    }
  }
}
?>
