<?php
session_start();
$temp = $_SESSION['username'];

//initializing variables
$username = "";
$email = "";
$errors = array();

//connect to Database userdb
$db = mysqli_connect('localhost', 'root', '' , 'userdb');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(isset($_POST['save'])){

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);

  // form validation
  if(empty($username)){array_push($errors, "Error : Username is required");}
  if(empty($email)){array_push($errors, "Error : Email is required");}

  $image = $_FILES['image']['name'];
  if(!isset($_FILES['image']) || !is_uploaded_file($_FILES['image']['tmp_name'])){
      $image= '../images/pic2.png';
      move_uploaded_file($_FILES['image']['tmp_name'], "$image");
  }
  else{

    $target = "images/" .basename($image);
      move_uploaded_file($_FILES['image']['tmp_name'], "$target");
  }
  $sql5 = "UPDATE data SET profile_pic ='$target' WHERE username = '$temp'";
  $sql6 = "INSERT INTO data (profile_pic) VALUES ('$target') WHERE username = '$temp'";
  $result = mysqli_query($db,"SELECT * FROM data WHERE username = '$temp'");
  if( mysqli_num_rows($result) > 0) {
      if(!empty($_FILES['image']['name'])){
          mysqli_query($db,$sql5)or die(mysqli_error($db));
          header('location: profile.php');
      }
  }
  else {
      mysqli_query($db,$sql6)or die(mysqli_error($db));
      header('location: profile.php');
  }

if(count($errors) == 0){
  $query1 = "UPDATE data SET username='$username', email='$email' WHERE username='$temp'";

  mysqli_query($db, $query1);
  $_SESSION['username'] = $username;
  $_SESSION['success'] = "Profile Updated";
  header('location: profile.php');
 }
}
$password_1="";
$password_2="";
if(isset($_POST['submitpass'])){


  $oldpassword = mysqli_real_escape_string($db, $_POST['oldpassword']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


  if(empty($oldpassword)){array_push($errors, "Error : Old Password is required");}
  if(empty($password_1)){array_push($errors, "Error : New Password is required");}
  if($password_1 != $password_2){array_push($errors, "Error : New Passwords do not match, Please try again.");}

  $user_check_query = "SELECT * FROM data WHERE username='$temp' LIMIT 1";

  $results = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($results);

  if($user){ //if user exists
    if($user['password'] != $oldpassword){array_push($errors, "old password is incorrect");
    }
  }



  if(count($errors) == 0){
    $Newpassword = md5($password_1);
    $query = "UPDATE data SET password='$Newpassword' WHERE username='$temp'";

    mysqli_query($db, $query);
    $_SESSION['success'] = "Password was successfully changed";
    header('location: profile.php');
   }

}

if(isset($_POST['delete'])){

  // sql to delete a record
$sql = "DELETE FROM data WHERE username = '$temp'";

if (mysqli_query($db, $sql)) {
    $_SESSION['success'] = "Your account was successfully deleted";
    header('location: login.php');
} else {
    $_SESSION['success'] = "Error deleting record: " . mysqli_error($db);
  }
}



if(isset($_POST['delete_post'])){

  $info = "SELECT * FROM donations WHERE name='$temp'";
  $info_result = mysqli_query($db, $info);
  $rowz = mysqli_fetch_assoc($info_result);
  $id = $rowz['id'];

  // sql to delete a record
$sqli = "DELETE FROM donations WHERE id = '$id'";

if (mysqli_query($db, $sqli)) {
    header('location: timeline.php');
} else {
    $_SESSION['success'] = "Error deleting record: " . mysqli_error($db);
  }
}

?>
