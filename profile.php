<?php
session_start();

if(!isset($_SESSION['username'])){
  $_SESSION['msg'] = "You must login first to view this page.";
  header("location: login.php");
}

if(isset($_GET['logout'])){
  session_destroy();
  unset($_SESSION['username']);
  header("location:login.php");
}

// Create database connection
  $db = mysqli_connect("localhost", "root", "", "userdb");
  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
// Initialize message variable

  $errors = array();
// If upload button is clicked ...
if(isset($_POST['upload'])){

  // Get image name
  $image = $_FILES['image']['name'];

  // Get text
  $name = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $country = mysqli_real_escape_string($db, $_POST['country']);
  $phone = mysqli_real_escape_string($db, $_POST['phone']);
  $address = mysqli_real_escape_string($db, $_POST['address']);
  $typeofdonation = mysqli_real_escape_string($db, $_POST['typeofdonation']);
  $image_text = mysqli_real_escape_string($db, $_POST['image_text']);

  // image file directory
  $target = "images/" .basename($image);

  $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));

    // Check file size
if ($_FILES["image"]["name"] > 600000) {
  array_push($errors, "Sorry, your image is too large.");
}
if(empty($name)){array_push($errors, "Username is required");}
if(empty($email)){array_push($errors, "Email is required");}
if(empty($country)){array_push($errors, "Please fill in the country");}
if(empty($phone)){array_push($errors, "Please fill in the phone number");}
if(empty($address)){array_push($errors, "Please fill in the address");}
if(empty($typeofdonation)){array_push($errors, "Please fill in the type");}
if(empty($image_text)){array_push($errors, "leave a comment");}


// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  array_push($errors, "Only JPG, JPEG, PNG & GIF files are allowed.");
}

if(count($errors) == 0){
  $sql = "INSERT INTO donations (name, email, country, phone, address, typeofdonation, donation_image, upload_date, comment) VALUES ('$name','$email','$country','$phone','$address','$typeofdonation','$target', NOW(), '$image_text')";
  	// execute query
  	mysqli_query($db, $sql);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    header('location: donations_list.php');
}

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
    $name = $_SESSION['username'];
    $get = "SELECT * FROM data WHERE username='$name'";
    $run_user = mysqli_query($db,$get);
    $row = mysqli_fetch_assoc($run_user);

    $user_email = $row['email'];
    $userid = $row['id'];
    $profile_pic = $row['profile_pic'];

     ?>

    <title>Welcome</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="profilecss/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.1/css/all.css">

    <style>

    #image--cover {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      object-fit: cover;
      /* object-position: center right; */
    }
    </style>
  </head>

  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="profile.php">SeekLife</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <h1>
      <?php

      if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
        unset($_SESSION['success']);
      }
      ?>
    </h1>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="page-user.php"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
            <li><a class="dropdown-item" href="page-user.php"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li>
              <?php if(isset($_SESSION['username'])) : ?>
                  <a class="dropdown-item" href="profile.php?logout=='1'"><i class="fa fa-sign-out fa-lg"></i>logout</a>
              <?php endif ?>
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><a href="page-user.php"><img src="<?php echo $profile_pic; ?>" class="app-sidebar__user-avatar" id="image--cover"></a>
        <div>
          <p class="app-sidebar__user-name"><?php echo $_SESSION['username']; ?></p>

        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="timeline.php"><i class="app-menu__icon icon fad fa-home-lg-alt"></i><span class="app-menu__label"> TimeLine</span></a></li>
        <li><a class="app-menu__item active" href="profile.php"><i class="app-menu__icon fa fa-universal-access"></i><span class="app-menu__label">Donation</span></a></li>
        <li><a class="app-menu__item" href="donations_list.php"><i class="app-menu__icon icon fa fa-history"></i><span class="app-menu__label">Donations List</span></a></li>
        <li><a class="app-menu__item" href="page-user.php"><i class="app-menu__icon icon fa fa-user-circle "></i><span class="app-menu__label">Profile</span></a></li>

      </ul>
    </aside>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-universal-access"></i>&nbsp;&nbsp;&nbsp;Donation</h1>
          <p>The easiest way to turn stuff you don't need, into a good deed.</p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Submit a Donation Form</h3>
            <h5 color="red"><?php include('errors.php') ?></h5>
            <style>
            h5{color:red;}
            </style>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="control-label">Name</label>
                  <input class="form-control" type="text" value="<?php echo $_SESSION['username']; ?>" name="username">
                </div>
                <div class="form-group">
                  <label class="control-label">Email</label>
                  <input class="form-control" type="email" value="<?php echo "$user_email"; ?>" name="email">
                </div>

                <div class="form-group">
                  <label class="control-label">Country</label>
                  <input class="form-control" type="text" name="country" placeholder="Country (Area Code)">
                </div>

                <div class="form-group">
                  <label class="control-label">Phone Number</label>
                  <input class="form-control" type="tel" name="phone">
                </div>

                <div class="form-group">
                  <label>Address</label>
                  <input class="form-control" type="text" name="address" placeholder="542 W. 15th Street">
                </div>

                <div class="form-group">
                  <label class="control-label">Type of Donation</label>
                  <input class="form-control" rows="4" placeholder="Enter your address" name="typeofdonation"></input>
                </div>

                <div class="form-group">
                  <label class="control-label">Choose your Donation</label>
                  <input class="form-control" type="file" name="image">
                </div>

                <div class="form-group">
                  <label class="control-label">Comment</label>
                  <textarea class="form-control" rows="4" placeholder="Say something" name="image_text"></textarea>
                </div>

                <div class="form-group">
                  <div class="tile-footer">
                    <button class="btn btn-primary" id="demoNotify" type="submit" name="upload"><i class="fa fa-fw fa-lg fa-check-circle"></i>Donate</button>
                  </div>
                </div>
              </form>
          </div>
        </div>
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>

  </body>
</html>
