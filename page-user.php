<?php

include('editprofile.php');
include("connection.php");

if(!isset($_SESSION['username'])){
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
  $name = $_SESSION['username'];
  $get = "SELECT * FROM data WHERE username='$name'";
  $run_user = mysqli_query($db,$get);
  $row = mysqli_fetch_assoc($run_user);

  $user_email = $row['email'];
  $profile_pic = $row['profile_pic'];
  $userid = $row['id'];
  $username = $row['username'];


  $sql = "SELECT * FROM donations WHERE name='$name'";
  if($sql){
    $results = mysqli_query($db, $sql);
  }

 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo "$name"; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="profilecss/main.css">
    <link rel="stylesheet" type="text/css" href="css/dono.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.1/css/all.css">
    <style>

    #image--cover {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      object-fit: cover;
    }

    #imagemedia{
      width: 55px;
      height: 55px;
      border-radius: 50%;
      object-fit: cover;
    }
    #profilepic{
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
    }
    /* Parent Container */
.content_img{
 position: relative;
 width: 200px;
 height: 200px;
 float: left;
}


/* Child Text Container */
.content_img div{
 position: absolute;
 bottom: 0;
 right: 0;
 background: black;
 color: white;
 margin-bottom: 5px;
 font-family: sans-serif;
 opacity: 0;
 visibility: hidden;
 -webkit-transition: visibility 0s, opacity 0.5s linear;
 transition: visibility 0s, opacity 0.5s linear;
}

/* Hover on Parent Container */
.content_img:hover{
 cursor: pointer;
}

.content_img:hover div{
 width: 150px;
 padding: 8px 15px;
 visibility: visible;
 opacity: 0.7;
}


    </style>

  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="profile.php">SeekLife</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
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
          <p class="app-sidebar__user-name"><?php echo $username; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="timeline.php"><i class="app-menu__icon icon fad fa-home-lg-alt"></i><span class="app-menu__label"> TimeLine</span></a></li>
        <li><a class="app-menu__item " href="profile.php"><i class="app-menu__icon fa fa-universal-access"></i><span class="app-menu__label">Donation</span></a></li>
        <li><a class="app-menu__item" href="donations_list.php"><i class="app-menu__icon icon fa fa-history"></i><span class="app-menu__label">Donations List</span></a></li>
        <li><a class="app-menu__item active" href="page-user.php"><i class="app-menu__icon icon fa fa-user-circle "></i><span class="app-menu__label">Profile</span></a></li>
      </ul>
    </aside>

    <main class="app-content">

      <div class="row user">
        <div class="col-md-12">
          <div class="profile">
            <div class="info">
                <img src="<?php echo $profile_pic; ?>" alt="avatar" id="profilepic">
              <h4><?php echo $username; ?></h4>
              <p class="app-sidebar__user-name"> User ID: <?php echo $userid; ?></p>
            </div>
            <div class="cover-image"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
              <li class="nav-item"><a class="nav-link active"  href="#user-settings" data-toggle="tab">Edit Profile</a></li>
              <li class="nav-item"><a class="nav-link" href="#change-Password" data-toggle="tab">Change Password</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <!-- User Settings -->
            <div class="tab-pane active" id="user-settings">
              <div class="tile user-settings">

                <h4 class="line-head">Edit Profile</h4>

                <form action="" method="post" enctype="multipart/form-data">

                  <?php include('errors.php') ?>

                  <div class="row">
                    <div class="col-md-8 mb-4">
                      <label>Username</label>
                      <input class="form-control" type="text" name="username" value="<?php echo $_SESSION['username']; ?>" required>
                    </div>
                    <div class="col-md-8 mb-4">
                      <label>Email</label>
                      <input class="form-control" type="text" name="email" value="<?php echo "$user_email"; ?>" required>
                    </div>

                    <div class="col-md-8 mb-4">
                      <label class="control-label">Profile Picture</label>
                      <input class="form-control" type="file" name="image">
                    </div>

                  </div>
                  <div class="row mb-10">
                    <div class="col-md-12">
                      <button class="btn btn-primary" type="submit" name="save"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                      <button class="btn btn-primary" type="submit" name="delete" id="delete_product"><i class="fas fa faw fa-trash-alt"></i>Delete Account</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- User Settings -->
            <div class="tab-pane fade" id="change-Password">
              <div class="tile user-settings">
                <h4 class="line-head">Change Password <i class="fa fa-unlock-alt "></i></h4>
                <form action="" method="post" enctype="multipart/form-data">
                  <?php include('errors.php') ?>

                  <div class="row">
                    <div class="col-md-8 mb-4">
                      <label>Old Password</label>
                      <input class="form-control" type="password" name="oldpassword" >
                    </div>
                    <div class="col-md-8 mb-4">
                      <label>New Password</label>
                      <input class="form-control" type="password" name="password_1">
                    </div>
                    <div class="clearfix"></div>
                    <!-- City -->
                    <div class="col-md-8 mb-4">
                      <label>Confirm New Password</label>
                      <input class="form-control" type="password" name="password_2" >
                    </div>
                  </div>
                  <div class="row mb-10">
                    <div class="col-md-12">
                      <button class="btn btn-primary" type="submit" name="submitpass" ><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main1.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>

  </body>
</html>
