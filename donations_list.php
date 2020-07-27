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
  $sql = "SELECT * FROM donations";
  $results = mysqli_query($db, $sql);


  $name = $_SESSION['username'];
  $get = "SELECT * FROM data WHERE username='$name'";
  $run_user = mysqli_query($db,$get);
  $row = mysqli_fetch_assoc($run_user);

  $user_email = $row['email'];
  $userid = $row['id'];
  $user_profile = $row['profile_pic'];

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

    .modalDialog {
        position: fixed;
        font-family: Arial, Helvetica, sans-serif;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: rgba(0,0,0,0.8);
        z-index: 99999;
        opacity:0;
        -webkit-transition: opacity 400ms ease-in;
        -moz-transition: opacity 400ms ease-in;
        transition: opacity 400ms ease-in;
        pointer-events: none;
    }

    .modalDialog:target {
        opacity:1;
        pointer-events: auto;
    }

    .modalDialog > div {
        width: 400px;
        position: relative;
        margin: 2% auto;
        padding: 0 20px 13px 20px;
        border-radius: 10px;
        background: #fff;
        background: -moz-linear-gradient(#fff, #999);
        background: -webkit-linear-gradient(#fff, #999);
        background: -o-linear-gradient(#fff, #999);
    }

    .close {
        background: #606061;
        color: #FFFFFF;
        line-height: 25px;
        position: absolute;
        right: -12px;
        text-align: center;
        top: -10px;
        width: 24px;
        text-decoration: none;
        font-weight: bold;
        -webkit-border-radius: 12px;
        -moz-border-radius: 12px;
        border-radius: 12px;
        -moz-box-shadow: 1px 1px 3px #000;
        -webkit-box-shadow: 1px 1px 3px #000;
        box-shadow: 1px 1px 3px #000;
    }

    .close:hover { background: #00d9ff; }


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
        <li><a class="app-menu__item" href="timeline.php"><i class="app-menu__icon icon fad fa-home-lg-alt"></i><span class="app-menu__label"> TimeLine</span></a></li>
        <li><a class="app-menu__item" href="profile.php"><i class="app-menu__icon fa fa-universal-access"></i><span class="app-menu__label">Donation</span></a></li>
        <li><a class="app-menu__item active" href="donations_list.php"><i class="app-menu__icon icon fa fa-history"></i><span class="app-menu__label">Donations List</span></a></li>
        <li><a class="app-menu__item" href="page-user.php"><i class="app-menu__icon icon fa fa-user-circle "></i><span class="app-menu__label">Profile</span></a></li>

      </ul>
    </aside>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-database" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</i>All Performed Donations</h1>
          <p> Start a beautiful journey here</p>
        </div>

      </div>
      <div class="row">
        <div class="table100">
					<table>
            <thead>
							<tr class="table100-head">
								<th class="column3"><i class="fas fa-calendar" aria-hidden="true"></i><br>Date</th>
								<th class="column3"><i class="fas fa-user" aria-hidden="true"></i><br>Name</th>
								<th class="column4"><i class="fas fa-envelope" aria-hidden="true"></i><br>Email</th>
								<th class="column6"><i class="fas fa-globe-asia" aria-hidden="true"></i></i><br>Country</th>
								<th class="column6"><i class="fas fa-phone-square" aria-hidden="true"></i></i><br>Phone</th>
								<th class="column7"><i class="fas fa-address-book" aria-hidden="true"></i><br>Address</th>
								<th class="column8"><i class="fas fa-info" aria-hidden="true"></i><br>About</th>
                <th class="column8"><i class="fas fa-hand-holding-heart"></i><br>Donation</th>
							</tr>
            </thead>
              <tbody>
              <?php
              if(mysqli_num_rows($results)){
                // output data of each row
                while($row = $results->fetch_assoc()) {
                  $picture = $row["donation_image"] ?>
                  <tr><td class="column1"> <?php echo $row["upload_date"] ?>
                   </td><td class="column3"> <?php echo $row["name"] ?>
                     </td><td class="column4"> <?php echo $row["email"] ?>
                     </td><td class="column6"> <?php echo $row["country"] ?>
                      </td><td class="column6"> <?php echo $row["phone"] ?>
                       </td><td class="column7"> <?php echo $row["address"] ?>
                       </td><td class="column8"> <?php echo $row["typeofdonation"] ?></td>
                         <td class="column9"><a href="#openModal<?php echo $row['id'] ;?>"><button ><i class="fas fa-arrow-alt-circle-down"></i></button></a></td>

                         <div id="openModal<?php echo $row['id'] ;?>" class="modalDialog">
                           <div>
                             <!-- only printing first row in database -->
                             <a href="#close" title="Close" class="close">X</a>
                             <h2><i class="fas fa-hand-holding-heart"></i> Donations:</h2>
                             <a href="localhost/../<?php echo $picture ?>"><img src="<?php echo $picture ?>" alt="click on image" width="100%" height="auto"></a>
                             <p><?php echo $row["comment"] ?></p>
                           </div>
                         </div>
                       </tr>
                      <?php }
                    echo "</table>";
                  } else { echo "0 results"; }
                  mysqli_close($db);
                  ?>
            </tbody>
					</table>
          </div>
      </div>

    </main>

    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main1.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
  </body>
</html>
