<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Page-->
    <title>Register</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/register.css" rel="stylesheet" media="all">
</head>
<style>
.txt2 {
  font-family: Poppins-Regular;
  line-height: 1.5;
  color: white;
  decoration: none;
  text-decoration: none;
}
a:hover {
  color: blue;
}

</style>

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <a class="navbar-brand logo_h" href="index.html"><img src="img/seeklife_180x100.png" alt=""></a>
                    <h2 class="title">Registration Form</h2>
                    <form action="reg.php" method="POST">

                      <?php include('errors.php') ?>

                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Username</label>
                                    <input class="input--style-4" type="text" name="username" required pattern = "^[A-Za-z0-9]{0,20}+">
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group" >
                                <label class="label">Email</label>
                                <input class="input--style-4" type="email" name="email" required>
                            </div>
                        </div>

                        <div class="row row-space">
                          <div class="col-2">
                              <div class="input-group">
                                  <label class="label">Password</label>
            									    <input class="input--style-4" type="password" name="password_1"  required pattern = "^[A-Za-z0-9]{0,20}+">
                                </div>
                          </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Confirm Password</label>
                                <input class="input--style-4" type="password" name="password_2" required pattern = "^[A-Za-z0-9]{0,20}+">
                            </div>
                        </div>


                        <div class="row row-space">
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit" name="reg_user">Register</button><br>

                              Already have an account?
                              <a class="txt2" href="login.php">
                                Login
                              <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                            </a>
                        </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>


</html>
