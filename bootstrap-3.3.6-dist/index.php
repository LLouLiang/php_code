<!DOCTYPE html>

<?php
	session_start(session_id("vs"));
	session_unset();
	session_destroy();
	session_start(session_id("vs"));
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Login</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/vs-style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="row">

        <div clas="col-md-12">
          <h1 id="header" class="text-center">Vetworking System</h1>
        </div>

        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php">Homepage</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
								<li><a href="about_us.php">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>

				<div class="jumbotron">

	        <?php

	          date_default_timezone_set("America/New_York");

	          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	            if($_POST['button']=='Login') {
	              $uname= $_POST['uname'];
	              $psword= $_POST['psword'];
	              $_SESSION['psword']= $psword;
	              $error = array();

	              if(empty($uname)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to enter user name!
																						</div>";
	              if(empty($psword)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to enter password!
																						</div>";

	              if(empty($error)) {

	                $last_login = date("y-m-d h:i:s");

	                //connect to database
	                include("dbc.php");

	                //define a query
	                $q = "SELECT * FROM users WHERE uname = '$uname'";

	                //excute the query
	                $r = mysqli_query($dbc, $q);

	                //excute the query
	                $num = mysqli_num_rows($r);

	                if ($num == 1) {
	                  $row = mysqli_fetch_array($r);

	                  $attempts = $row['attempts'];
	                  $last_attempt = $row['last_attempt'];

	                  if($attempts >= 2) {
	                    $current_time = date_format(new DateTime(), "y-m-d h:i:s");
	                    if(strtotime($current_time) < (strtotime($last_attempt) + 60)) {
	                      echo "<div class='alert alert-danger alert-dismissible' role='alert'>
															<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
															</button>
															<strong>Warning!</strong> You have exceeded the login attempts limit!
															</div>";
	                      echo "<div class='alert alert-danger alert-dismissible' role='alert'>
															<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
															</button>
															<strong>Warning!</strong> You will be blocked for ".((strtotime($last_attempt)+60)-strtotime($current_time))." seconds
															</div>";
	                    }
	                    else{
	                      $attempts = 0;
	                      //define a query
	                      $q = "UPDATE users SET attempts='$attempts' WHERE uname='$uname'";
	                      //excute the query
	                      $r = mysqli_query($dbc, $q);
	                    }
	                  }

	                  if($attempts < 3){
	                    $pwd = SHA1($psword);

	                    if ($pwd == $row['psword']) {
	                      $_SESSION['uname'] = $uname;
	                      $attempts = 0;
	                      //define a query
	                      $qq = "UPDATE users SET attempts='$attempts', last_login='$last_login' WHERE uname='$uname'";
	                      //excute the query
	                      $rr = mysqli_query($dbc, $qq);

	                      if($row['role'] == 'veteran'){
	                        //header('LOCATION: veteran.php');
													$_SESSION['role'] = $row['role'];
	                        echo "<script>window.open('veteran/veteran.php','_self')</script>";
	                      }
	                      else if($row['role'] == 'mentor'){
	                        //header('LOCATION: mentor.php');
													$_SESSION['role'] = $row['role'];
	                        echo "<script>window.open('mentor/mentor.php','_self')</script>";
	                      }
	                      else if($row['role'] == 'host'){
	                        //header('LOCATION: host.php');
													$_SESSION['role'] = $row['role'];
	                        echo "<script>window.open('host/host.php','_self')</script>";
	                      }
	                      else if($row['role'] == 'caterer'){
	                        //header('LOCATION: caterer.php');
													$_SESSION['role'] = $row['role'];
	                        echo "<script>window.open('caterer/caterer.php','_self')</script>";
	                      }
	                      else if($row['role'] == 'assessment_expert'){
	                        //header('LOCATION: assessment_exp.php');
													$_SESSION['role'] = $row['role'];
	                        echo "<script>window.open('assessment_exp/assessment_exp.php','_self')</script>";
	                      }
	                      else if($row['role'] == 'career_coach'){
	                        //header('LOCATION: career_coach.php');
													$_SESSION['role'] = $row['role'];
	                        echo "<script>window.open('career_coach/career_coach.php','_self')</script>";
	                      }
	                      else if($row['role'] == 'resume_expert'){
	                        //header('LOCATION: resume_exp.php');
													$_SESSION['role'] = $row['role'];
	                        echo "<script>window.open('resume_exp/resume_exp.php','_self')</script>";
	                      }
	                      else if($row['role'] == 'panelist_recruiter'){
	                        //header('LOCATION: panelist_recruiter.php');
													$_SESSION['role'] = $row['role'];
	                        echo "<script>window.open('panelist_recruiter/panelist_recruiter.php','_self')</script>";
	                      }
	                      else if($row['role'] == 'job_fair_recruiter'){
	                        //header('LOCATION: job_fair_recruiter.php');
													$_SESSION['role'] = $row['role'];
	                        echo "<script>window.open('job_fair_recruiter/job_fair_recruiter.php','_self')</script>";
	                      }
												else{
													echo "<script>window.open('index.php','_self')</script>";
												}

	                    }
	                    else {
	                      $attempts = $attempts + 1;
	                      $last_attempt = date_format(new DateTime(), "y-m-d h:i:s");
	                      //define a query
	                      $qqq = "UPDATE users SET attempts = '$attempts',
	                                  last_attempt = '$last_attempt'
	                                  WHERE uname = '$uname'";
	                      //excute the query
	                      $rrr = mysqli_query($dbc, $qqq);
	                      echo "<div class='alert alert-danger alert-dismissible' role='alert'>
															<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
															</button>
															<strong>Warning!</strong> Wrong password! You have tried $attempts times
															</div>";
	                    }
	                  }
	                }
	                else
	                  echo "<div class='alert alert-danger alert-dismissible' role='alert'>
													<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
													<span aria-hidden='true'>&times;</span>
													</button>
													<strong>Warning!</strong> Unknown username. Please try again!
													</div>";
	              }
	              else {
	                //print error information
	                foreach ($error as $err){
	                  echo $err;
	                  echo "<br>";
	                }
	              }
	            }
	            else { echo "error"; }
	          }
	        ?>

          <p class="text-center">Welcome to Vetworking System</p>

          <form action="" method="POST" class="form-horizontal">
            <div class="form-group">
              <label for="uname" class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10"> <!-- Choose the default size, it was full "10" -->
                <input type="text" class="form-control" id="uname" placeholder="Username" name="uname" value =
								<?php if(isset($_POST['uname'])) echo $_POST['uname'] ?>>
              </div>
            </div>
            <div class="form-group" method="POST">
              <label for="psword" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10"> <!-- Choose the default size, it was full "10" -->
                <input type="password" class="form-control" id="psword" placeholder="Password" name="psword">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Remember me
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="button" value="Login">Sign in</button>
              </div>
            </div>
          </form>
          <div class="text-center">
            <a  class="btn btn-info" href="register.php" role="button">If you don't have an account, click here to register</a>
          </div>
        </div> <!-- /.jumbotron -->

        <div clas="col-md-12">
          <p id="footer" class="text-center">Copyright@ MITRE Business Strategist</p>
        </div>

      </div> <!-- /.row -->
    </div> <!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>

</html>
