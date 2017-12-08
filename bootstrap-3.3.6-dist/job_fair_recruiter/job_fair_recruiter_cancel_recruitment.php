<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
	session_start(session_id("vs"));
?>

<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Cancel recruitment</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/vs-style.css" rel="stylesheet">
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/pagination.js"></script>
    <script>
    $(document).ready(function(){
     $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:20});
    });
    </script>
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
						$role = $_SESSION['role'];
					}
				?>

				<!-- .jumbotron -->
        <div class="jumbotron">

					<?php
						$uname = "";

						if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel'])) {
						$bc_host_name = $_POST['bc_host_name'];
						$att_id = $_POST['att_id'];
			 			//connect to database
			 			include("../dbc.php");

						$update = "DELETE FROM bootcamps_attendances WHERE att_id = '$att_id'";
						$z= mysqli_query($dbc, $update);
						$q = "SELECT email,fname FROM users WHERE uname = '$bc_host_name'";
						$r = mysqli_query($dbc, $q);
						if (mysqli_num_rows($r) == 1){
								$row = mysqli_fetch_array($r);
								$email = $row['email'];
								$fname = $row['fname'];
							}

						echo "<div class='alert alert-warning alert-dismissible' role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
									</button>
									<strong>Warning!</strong> You have canceled your attending to the boot camp!
									</div>";

							$to = $email;
							$subject = 'A Job Fair Recruiter has canceled attending to boot camp';
							$message = "Hi ". $fname .", \n\nThe Job Fair Recruiter $_SESSION[uname] has canceled his/her attending to the boot camp! .\nClick here to login.\nhttp://vetworking.x10host.com/bootstrap-3.3.6-dist/index.php\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
							$headers = 'From: Veyworking System' . "\r\n" .
											'Reply-To: ' . "\r\n" .
											'X-Mailer: PHP/' . phpversion();
							mail($to, $subject, $message, $headers);
						}

					?>

					<p>Here is a list of the boot camps that you have registered in with all their information:</p>

					<!-- To make the table scroll horizontally on small devices -->
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
							<tr class="info">
								<th> Hosted By </th>
								<th> Title </th>
								<th> Description </th>
								<th> Starts Date </th>
								<th> End Date </th>
								<th> Time </th>
								<th> Location </th>
								<th id="center-th" colspan="2"> Actions </th>
							</tr>
							</thead>
							<tbody id = "myTable">

						<?php
							//connect to database
							include("../dbc.php");
							$q = "SELECT * FROM bootcamps_attendances WHERE username = '$_SESSION[uname]' AND att_status = 'approved'";

							$r = mysqli_query($dbc, $q);

							while ($row = mysqli_fetch_array($r)){
								echo "<form action='job_fair_recruiter_cancel_recruitment.php' method='POST'>";
								echo "<tr>";
								echo "<td>".$row['bc_host_name']."</td>";
									echo "<td>".$row['bc_title']."</td>";
									echo "<td>".$row['bc_description']."</td>";
									echo "<td>".$row['bc_startdate']."</td>";
									echo "<td>".$row['bc_enddate']."</td>";
									echo "<td>".$row['bc_time']."</td>";
									echo "<td>".$row['bc_location']."</td>";
									echo '</td>';
									echo '<td id="center-th"><input type = "submit" class="btn btn-warning" name = "cancel" value = "Cancel" />';
									echo '</td>';
									echo '<input type = "hidden" name = "att_id" value = "'.$row['att_id'].'">';
									echo '<input type = "hidden" name = "bc_host_name" value = "'.$row['bc_host_name'].'">';
								echo "</tr>";
								echo "</form>";
							}

						?>
						</tbody>

						</table> <!-- /table -->
						</div> <!--table-responsive-->

						<div class="text-center">
					    	<ul class="pagination" id="myPager"></ul>
					  </div>

					</div> <!-- /.jumbotron -->

				<!-- #footer -->
        <div clas="col-md-12">
            <p id="footer" class="text-center">Copyright@ MITRE Business Strategist</p>
        </div>
				<!-- /#footer -->

        </div> <!-- /.row -->
    </div> <!-- /.container -->

  </body>

</html>
