<!DOCTYPE html>

<?php
	session_start(session_id("vs"));
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Register</title>

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

	            if($_POST['button']=='Register') {	//register button was hit

	              $role = $_POST['role'];

	              if(empty($role)){
									echo "<div class='alert alert-danger alert-dismissible' role='alert'>
													<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
														<span aria-hidden='true'>&times;</span>
													</button>
													<strong>Warning!</strong> You forgot to select a role!
												</div>";
								}
	              else{
	                $_SESSION['role'] = $role;
									echo "<script>window.open('registration/registration_".$role.".php', '_self')</script>";
	              }
	            }
							else{ echo "error"; }
	          }
	        ?>

          <form class="text-center" action="" method="POST" class="form-horizontal">
            <p class="text-center">Sign Up as a: </p>
            <div class="radio">
              <label><input type="radio" name="role" id="optionsRadios1" value="veteran">Veteran</label>
  						<label><input type="radio" name="role" id="optionsRadios1" value="mentor">Mentor</label>
  						<label><input type="radio" name="role" id="optionsRadios1" value="host">Host</label>
  					  <label><input type="radio" name="role" id="optionsRadios1" value="caterer">Caterer</label>
  						<label><input type="radio" name="role" id="optionsRadios1" value="assessment_expert">Assessment Expert</label>
  						<label><input type="radio" name="role" id="optionsRadios1" value="career_coach">Career Coach</label>
  						<label><input type="radio" name="role" id="optionsRadios1" value="resume_expert">Resume Expert</label>
  						<label><input type="radio" name="role" id="optionsRadios1" value="panelist_recruiter">Panelist Recruiter</label>
  						<label><input type="radio" name="role" id="optionsRadios1" value="job_fair_recruiter">Job Fair Recruiter</label>
            </div> <!-- /.radio -->
            <div class="form-group" id="register-btn" style="padding: 10px 0px 0px 0px">
              <div class="text-center" class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success btn-lg" name="button" value="Register">Register</button>
              </div>
            </div>
          </form>
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
