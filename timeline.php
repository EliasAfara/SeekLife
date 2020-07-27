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
    <title>Donations List</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="profilecss/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="profilecss/main.css">
    <link rel="stylesheet" type="text/css" href="css/dono.css">
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
      <div class="app-sidebar__user"><a href="page-user.php"><img src="<?php echo $row['profile_pic']; ?>" class="app-sidebar__user-avatar" id="image--cover"></a>
        <div>
          <p class="app-sidebar__user-name"><?php echo $_SESSION['username']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="timeline.php"><i class="app-menu__icon icon fad fa-home-lg-alt"></i><span class="app-menu__label"> TimeLine</span></a></li>
        <li><a class="app-menu__item" href="profile.php"><i class="app-menu__icon fa fa-universal-access"></i><span class="app-menu__label">Donation</span></a></li>
        <li><a class="app-menu__item" href="donations_list.php"><i class="app-menu__icon icon fa fa-history"></i><span class="app-menu__label">Donations List</span></a></li>
        <li id="demoNotify"><a class="app-menu__item" href="page-user.php"><i class="app-menu__icon icon fa fa-user-circle "></i><span class="app-menu__label">Profile</span></a></li>

      </ul>
    </aside>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-database" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</i>All Personal Donations</h1>

        </div>

      </div>

        <div class="row user">
          <div class="col-md-12">
          </div>
          <div class="col-md-9">
            <div class="tab-content">
              <!-- User timeline -->
              <?php
              if(mysqli_num_rows($results)){
                // output data of each row
                while($row = $results->fetch_assoc()) { ?>
              <div class="tab-pane active" id="user-timeline">
                <div class="timeline-post">
                  <div class="post-media"><a href="page-user.php">
                    <div class="image-cropper">
                    <img class="user-img" src="<?php echo $profile_pic; ?>" id="imagemedia"></a>
                  </div>
                    <div class="content">
                      <h5><a href="page-user.php"><?php echo $username; ?></a></h5>
                      <p class="text-muted"><small><?php echo $row["upload_date"] ?></small></p>
                    </div>
                    <ul class="app-nav">
                      <!-- User Menu-->
                      <li class="dropdown"><a  href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fas fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu settings-menu dropdown-menu-right">
                          <li>
                          <form action="" method="post" enctype="multipart/form-data">
                            <button type="submit" name="delete_post" class="dropdown-item" ><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;&nbsp;Delete</button>
                            </form>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="post-content">
                    <div class="row">
                      
                      <div class="table100">
                        <table>
                          <thead>
                            <tr class="table100-head">
              								<th class="column3"><i class="fas fa-list-ol" aria-hidden="true"></i><br>ID</th>
              								<th class="column3"><i class="fas fa-user" aria-hidden="true"></i><br>Name</th>
              								<th class="column4"><i class="fas fa-envelope" aria-hidden="true"></i><br>Email</th>
              								<th class="column6"><i class="fas fa-globe-asia" aria-hidden="true"></i></i><br>Country</th>
              								<th class="column6"><i class="fas fa-phone-square" aria-hidden="true"></i></i><br>Phone</th>
              								<th class="column7"><i class="fas fa-address-book" aria-hidden="true"></i><br>Address</th>
              								<th class="column8"><i class="fas fa-info" aria-hidden="true"></i><br>About</th>
              							</tr>
                          </thead>
                            <tbody>
                              <tr><td class="column02"> <?php echo $row["id"] ?>
                              </td><td class="column03"> <?php echo $row["name"] ?>
                              </td><td class="column04"> <?php echo $row["email"] ?>
                              </td><td class="column05"> <?php echo $row["country"] ?>
                                 </td><td class="column06"> <?php echo $row["phone"] ?>
                                  </td><td class="column07"> <?php echo $row["address"] ?>
                                   </td><td class="column08"> <?php echo $row["typeofdonation"] ?>
                                   </tr>
                          </tbody>
                        </table>
                        <hr>
                        <div>
                          <div class="content_img">
                            <a href="localhost/../<?php echo $row["donation_image"] ?>"><img src="<?php echo $row["donation_image"] ?>" width="100%" height="auto"></a>
                            <div>Click to view Image</div>
                          </div>
                          <br>
                            <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["comment"] ?></h4>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
              </div>
            <?php }
          }else { echo "<h4> Your timeline is empty! </h4>"; }
            mysqli_close($db);
            ?>
              <!-- User timeline -->

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
