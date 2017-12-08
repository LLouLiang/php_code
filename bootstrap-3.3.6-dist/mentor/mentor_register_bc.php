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

    <title>Boot Camp Registration</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/vs-style.css" rel="stylesheet">

    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
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

				<!-- including the mentor's header -->
				<?php include("../includes/mentor_header.html"); ?>

				<?php
					if( (empty($_SESSION['uname'])) || ($_SESSION['role'] != 'mentor') )
					{
						echo "<script>window.open('../index.php','_self');</script>";
					}
					else{
						$uname = $_SESSION['uname'];
					}
				?>

				<!-- .jumbotron -->
        <div class="jumbotron">

					<?php
						$uname = "";

						if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {

							$bc_id = $_POST['bc_id'];
							$bc_host_name = $_POST['bc_host_name'];
							$bc_title = $_POST['bc_title'];
							$bc_description = $_POST['bc_description'];
							$bc_startdate = $_POST['bc_startdate'];
							$bc_enddate = $_POST['bc_enddate'];
							$bc_time = $_POST['bc_time'];
							$bc_location = $_POST['bc_location'];
							$role = $_SESSION['role'];

							include("../dbc.php");

							$insert = "INSERT INTO bootcamps_attendances (bc_id,
																														bc_host_name,
																														bc_title,
																														bc_description,
																														bc_startdate,
																														bc_enddate,
																														bc_time,
																														bc_location,
																														username,
																														role) VALUES
																														('$bc_id',
																														'$bc_host_name',
																														'$bc_title',
																														'$bc_description',
																														'$bc_startdate',
																														'$bc_enddate',
																														'$bc_time',
																														'$bc_location',
																														'$_SESSION[uname]',
																														'$role')";
							$z= mysqli_query($dbc, $insert);
							$q = "SELECT email,fname FROM users WHERE uname = '$bc_host_name'";
							$r = mysqli_query($dbc, $q);
							if (mysqli_num_rows($r) == 1){
									$row = mysqli_fetch_array($r);
									$email = $row['email'];
									$fname = $row['fname'];
								}

							echo "<div class='alert alert-success alert-dismissible' role='alert'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
										<span aria-hidden='true'>&times;</span>
										</button>
										<strong>Warning!</strong> You have sent your registration request to the boot camp!
										</div>";

								$to = $email;
								$subject = 'You have got a registration request from a Mentor';
								$message = "Hi ". $fname .", \n\nYou have a registration request from a Mentor from Vetworking Sysyem .\nClick here to login.\nhttp://vetworking.x10host.com/bootstrap-3.3.6-dist/index.php\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
								$headers = 'From: Veyworking System' . "\r\n" .
												'Reply-To: ' . "\r\n" .
												'X-Mailer: PHP/' . phpversion();
								mail($to, $subject, $message, $headers);
							}
					?>

					<p>Here is a list of the boot camps that you can register to:</p>

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

								$qq = "SELECT * FROM bootcamps
								WHERE bc_id NOT IN (SELECT bc_id FROM bootcamps_attendances WHERE username = '$_SESSION[uname]')";

								$rr = mysqli_query($dbc, $qq);

								while ($row = mysqli_fetch_array($rr)){
									echo "<form action='mentor_register_bc.php' method='POST'>";
										echo "<tr>";
											echo "<td>".$row['bc_host_name']."</td>";
											echo "<td>".$row['bc_title']."</td>";
											echo "<td>".$row['bc_description']."</td>";
											echo "<td>".$row['bc_startdate']."</td>";
											echo "<td>".$row['bc_enddate']."</td>";
											echo "<td>".$row['bc_time']."</td>";
											echo "<td>".$row['bc_location']."</td>";
											echo '<td id="center-th"><input type = "submit" class="btn btn-success" name = "register" value = "Register" />';
											echo '</td>';
											echo '<input type = "hidden" name = "bc_id" value = "'.$row['bc_id'].'">';
											echo '<input type = "hidden" name = "bc_host_name" value = "'.$row['bc_host_name'].'">';
											echo '<input type = "hidden" name = "bc_title" value = "'.$row['bc_title'].'">';
											echo '<input type = "hidden" name = "bc_description" value = "'.$row['bc_description'].'">';
											echo '<input type = "hidden" name = "bc_startdate" value = "'.$row['bc_startdate'].'">';
											echo '<input type = "hidden" name = "bc_enddate" value = "'.$row['bc_enddate'].'">';
											echo '<input type = "hidden" name = "bc_time" value = "'.$row['bc_time'].'">';
											echo '<input type = "hidden" name = "bc_location" value = "'.$row['bc_location'].'">';
										echo "</tr>";
									echo "</form>";
								}

							?>
							</tbody>
						</table>
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

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>
