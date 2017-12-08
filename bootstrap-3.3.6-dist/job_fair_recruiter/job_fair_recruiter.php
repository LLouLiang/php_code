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

    <title>Job Fair Recruiter's Control Panel</title>

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

				<!-- including the job_fair_recruiter's header -->
				<?php include("../includes/job_fair_recruiter_header.html"); ?>

				<?php
					if( (empty($_SESSION['uname'])) || ($_SESSION['role'] != 'job_fair_recruiter') )
					{
						echo "<script>window.open('../index.php','_self');</script>";
					}
					else{
						$uname = $_SESSION['uname'];
					}
				?>

				<!-- .jumbotron -->
        <div class="jumbotron">

					<p>Welcome, <?php echo $uname; ?> :)</p>

					<!-- retrieve the user's role -->
					<?php
						//connect to database
						include("../dbc.php");

						$rl = "SELECT role FROM users WHERE uname = '$uname'";
						$rrll = mysqli_query($dbc, $rl);

						while ($row = mysqli_fetch_array($rrll)){
								$role = $row['role'];
								$_SESSION['role'] = $role;
						}
					?>
					<!-- end retrieving -->

					<?php
						//connect to database
						include("../dbc.php");
						$q = "SELECT * FROM users WHERE uname = '$_SESSION[uname]'";

						$r = mysqli_query($dbc, $q);

						while ($row = mysqli_fetch_array($r)){
						echo "<div>";
							echo "<div class='row'>";
								echo "<div class='col-xs-12 col-sm-6 col-md-6'>";
									echo "<div class='well well-sm'>";
										echo "<div class='row'>";
											echo "<div class='col-sm-6 col-md-4'>";
												echo "<img src='".'../uploads/'.$row['image']."' alt='' class='img-rounded img-responsive' />";
											echo "</div>";
												echo "<div class='col-sm-6 col-md-8'>";
														echo "<p>".$row['fname']." ".$row['lname']."
														<br />
														<i class='glyphicon glyphicon-globe'></i> ".$row['city'].", ".$row['state']."
														<br />
														<i class='glyphicon glyphicon-envelope'></i> ".$row['email']."
														<br />
														<i class='glyphicon glyphicon-briefcase'></i> ".$row['industry_work']."
														</p>";
												echo "</div>";
											echo "</div>";
										echo "</div>";
									echo "</div>";
								echo "</div>";
							echo "</div>";
						}

					?>

        </div> <!-- /.jumbotron -->

        <div clas="col-md-12">
          <p id="footer" class="text-center">Copyright@ MITRE Business Strategist</p>
        </div>

      </div> <!-- /.row -->
    </div> <!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>

  </body>

</html>
