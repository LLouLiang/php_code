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

    <title>Change Password</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/vs-style.css" rel="stylesheet">

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

				<!-- including the caterer's header -->
				<?php include("../includes/mentor_header.html"); ?>

				<!-- .jumbotron -->
        <div class="jumbotron">

					<?php
						if( (empty($_SESSION['uname'])) || ($_SESSION['role'] != 'mentor') )
						{
							echo "<script>window.open('../index.php','_self');</script>";
						}
						else{
							$uname = $_SESSION['uname'];
						}

						//retrieve session data
						$uname = $_SESSION['uname'];
						$psword = $_SESSION['psword'];

						if (isset($_GET['role'])) $role = $_GET['role'];
						if ($_SERVER['REQUEST_METHOD'] == 'POST'){

							$dbpass = $_GET['psword'];
							$mypsword = $_POST['mypsword'];
							$npsword = $_POST['npsword'];
							$cpsword = $_POST['cpsword'];

							$error = array();

							if(empty($mypsword)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to enter your Current Password!
																						</div>";

							if(empty($npsword)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to enter your New Password
																						</div>";

							if(empty($cpsword)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to re-enter your New Password!
																						</div>";

							if(empty($error)) {

								//connect to database
								include("../dbc.php");

								//define a query
								if($mypsword != $psword)
								{
									echo "<div class='alert alert-danger alert-dismissible' role='alert'>
												<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
												<span aria-hidden='true'>&times;</span>
												</button>
												<strong>Warning!</strong> The Current Password is Wrong!!
												</div>";
								}
								else if ($cpsword!=$npsword) {
									echo "<div class='alert alert-danger alert-dismissible' role='alert'>
												<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
												<span aria-hidden='true'>&times;</span>
												</button>
												<strong>Warning!</strong> The New Passwords Do Not Match!!
												</div>";
								}
								else{
									//echo "Password changed";
									$q = "UPDATE users SET psword = SHA1('$npsword') WHERE uname = '$uname'";
								}

								//excute the query
								$r = mysqli_query($dbc, $q);

								if ($r){
									echo "<script>window.open('successfully_changed_password.php', '_self')</script>";
								}
								else{
									//echo "Error!";
								}
							}
							else {
								//print error information
								foreach ($error as $err){
									echo $err;
									//echo "<br>";
								}
							}
						}
					?>

					<!-- form -->
          <form action="" method="POST" class="form-horizontal">

            <!-- current password -->
            <div class="form-group">
              <label for="mypsword" class="col-sm-2 control-label">Current Password:</label>
              <div class="col-sm-10">
								<input type="password" class="form-control" id="mypsword" placeholder="Current Password" name="mypsword">
              </div>
            </div>
            <!-- /current password -->

            <!-- new password -->
            <div class="form-group">
              <label for="lname" class="col-sm-2 control-label">New Password:</label>
              <div class="col-sm-10">
								<input type="password" class="form-control" id="npsword" placeholder="New Password" name="npsword">
              </div>
            </div>
            <!-- /new password -->

            <!-- confirm new password -->
            <div class="form-group">
              <label for="address" class="col-sm-2 control-label">Confirm New Password:</label>
              <div class="col-sm-10">
								<input type="password" class="form-control" id="cpsword" placeholder="Confirm New Password" name="cpsword">
              </div>
            </div>
            <!-- /confirm new password -->

            <!-- register button -->
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-warning" name="submit" value="change">Change</button>
              </div>
            </div>
            <!-- /register button -->

          <!-- /form -->
          </form>

        </div> <!-- /.jumbotron -->

				<!-- #footer -->
        <div clas="col-md-12">
          <p id="footer" class="text-center">Copyright@ MITRE Business Strategist</p>
        </div>
				<!-- /#footer -->

      </div> <!-- /.row -->
    </div> <!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>

  </body>

</html>
