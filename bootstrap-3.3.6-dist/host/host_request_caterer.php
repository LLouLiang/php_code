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

    <title>Request a Caterer</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/vs-style.css" rel="stylesheet">
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/pagination.js"></script>
    <script>
    $(document).ready(function(){
     $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:10});
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

				<!-- including the host's header -->
				<?php include("../includes/host_header.html"); ?>

				<?php
					if (!empty($_SESSION['uname'])){
						$uname = $_SESSION['uname'];
					}
					else{
						echo "<script>window.open('../index.php','_self');</script>";
					}
				?>

				<!-- .jumbotron -->
        <div class="jumbotron">

					<?php

						if (isset($_GET['role'])) $role = $_GET['role'];

						$bc_title = "";

						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							$bc_title = $_POST['bc_title'];
						}

						if (isset($_GET['bc_id'])) {

						include("../dbc.php");

			 			$bc_id = $_GET['bc_id'];

						$q = "SELECT * FROM bootcamps WHERE bc_id = '$bc_id'";

						$r = mysqli_query($dbc, $q);

						if (mysqli_num_rows($r) == 1){
							$row = mysqli_fetch_array($r);

							$bc_host_name = $row['bc_host_name'];
							$bc_title = $row['bc_title'];
							$bc_description = $row['bc_description'];
							$bc_startdate = $row['bc_startdate'];
							$bc_enddate = $row['bc_enddate'];
							$bc_time = $row['bc_time'];
							$bc_location = $row['bc_location'];
							$role = $_SESSION['role'];
							$username_requested = $_SESSION['username_requested'];

							if(!empty($username_requested)){
								$insert = "INSERT INTO bootcamps_attendances (bc_id,
																															bc_host_name,
																															bc_title,
																															bc_description,
																															bc_startdate,
																															bc_enddate,
																															bc_time,
																															bc_location,
																															username,
																															att_status) VALUES
																															('$bc_id',
																															'$bc_host_name',
																															'$bc_title',
																															'$bc_description',
																															'$bc_startdate',
																															'$bc_enddate',
																															'$bc_time',
																															'$bc_location',
																															'$username_requested',
																															'requested')";

									$z= mysqli_query($dbc, $insert);

									if($z){

										// start send email
										$qq = "SELECT email, fname FROM users WHERE uname= '$username_requested'";
										$rr = mysqli_query($dbc, $qq);
										if (mysqli_num_rows($rr) == 1){
											$row = mysqli_fetch_array($rr);
											$uname = $row['username'];
											$fname = $row['fname'];
										}

										//send confirmation to users email
										$sendtoemail = $row['email'];
										$fname = $row['fname'];

										$to = $sendtoemail;
										$subject = 'You have got a request from VS';
										$message = "Hi ". $fname .", \n\nYou have been requested from a Host from Vetworking Sysyem .\nClick here to login.\nhttp://vetworking.x10host.com/bootstrap-3.3.6-dist/index.php\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
										$headers = 'From: Veyworking System' . "\r\n" .
														'Reply-To: ' . "\r\n" .
														'X-Mailer: PHP/' . phpversion();
										mail($to, $subject, $message, $headers);
										// end send email

										echo "<script>window.open('successfully_requested_caterer.php', '_self')</script>";
									}
									else{
										echo "something wrong";
									}
								}
								else{
									echo "<div class='alert alert-danger alert-dismissible' role='alert'>
													<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
													<span aria-hidden='true'>&times;</span>
													</button>
													<strong>Warning!</strong> You forgot to select a Catere to send the request to!
												</div>";
								}
							}
						}
					?>

					<p>Here is a list of the boot camps that you have created:</p>

					<!-- To make the table scroll horizontally on small devices -->
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<form class="form-horizontal" action='host_request_caterer.php' method=post>
								<tr class="warning">
									<td class="text-danger" colspan="6">Please select the Caterer that you want to request. Then, select the boot camp that you want to make the request to:</td>
									<td id="center-th" colspan="1">
										<?php
											//connect to database
											include("../dbc.php");

											$qq = "SELECT * FROM users WHERE role = 'caterer'";

											$rr = mysqli_query($dbc,$qq);

											while ($row = mysqli_fetch_array($rr)){
												$array[] = $row['uname'];
											}

											echo '<select class="form-control" name="uname_requested">';
											foreach($array as $ro){
												echo '<option value="'.$ro.'">'.$ro.'</option>';
											}
											echo '</select>';
										?>
									</td>
									<td id="center-th" colspan="1">
										<input type=submit class="btn btn-danger" value="Select">
									</td>
								</tr>
							</form>

							<?php
								$username_requested = $_POST['uname_requested'];
							 	$_SESSION['username_requested'] = $username_requested;
							?>
							<thead>
								<tr class="info">
									<th> Title </th>
									<th> Description </th>
									<th> Starts Date </th>
									<th> End Date </th>
									<th> Time </th>
									<th> Location </th>
									<th> You are requesting </th>
									<th id="center-th" colspan="2"> Actions </th>
								</tr>
								</thead>
								<tbody id = "myTable">
								<?php
									//connect to database
									include("../dbc.php");

									$qq = "SELECT * FROM bootcamps
									WHERE bc_host_name = '$uname' AND bc_id NOT IN (SELECT bc_id FROM bootcamps_attendances WHERE username = '$username_requested')";

									$rr = mysqli_query($dbc, $qq);

									while ($row = mysqli_fetch_array($rr)){
										echo "<tr>";
											echo "<td>".$row['bc_title']."</td>";
											echo "<td>".$row['bc_description']."</td>";
											echo "<td>".$row['bc_startdate']."</td>";
											echo "<td>".$row['bc_enddate']."</td>";
											echo "<td>".$row['bc_time']."</td>";
											echo "<td>".$row['bc_location']."</td>";
											echo "<td>".$username_requested."</td>";
											echo  "<td id='center-td'><a onClick=\"javascript: return confirm('Do you really want to make a request for the caterer to this boot camp?');\"  href = 'host_request_caterer.php?bc_id=". $row['bc_id'] . "'>Select</a></td>";
										echo "</tr>";
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
