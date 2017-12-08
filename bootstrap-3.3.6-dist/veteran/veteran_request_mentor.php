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

    <title>Request a Mentor</title>

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
			<!-- including the career_coach's header -->
			<?php include("../includes/veteran_header.html"); ?>

			<?php
				if( (empty($_SESSION['uname'])) || ($_SESSION['role'] != 'veteran') )
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

						if ($_SERVER['REQUEST_METHOD'] == 'POST') {

						$receiver = $_POST['uname'];

						if($receiver != "")
						{

						//1. connect to db
						include("../dbc.php");

						$sendtoemail = $_POST['email'];

						//2. define a query (insert record to classes table)
						$s = "INSERT INTO requests (veteran_name,mentor_name,activity) VALUES('$uname','$receiver','request')";

						//3. execute the query
						$z = mysqli_query($dbc, $s);

						//4. sanity check
						if ($z) {
							$qq = "SELECT * FROM users WHERE uname= '$receiver'";
							$rr = mysqli_query($dbc, $qq);
							if (mysqli_num_rows($rr) == 1){
								$row = mysqli_fetch_array($rr);
								$uname = $row['uname'];
								$fname = $row['fname'];
							}

							//send confirmation to users email
							echo "<div class='alert alert-success alert-dismissible' role='alert'>
									 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									 <span aria-hidden='true'>&times;</span>
									 </button>
									 <strong>Warning!</strong> Your request has been sent!
									 </div>";
							$to = $sendtoemail;
							$subject = 'You have got a request from VS';
							$message = "Hi ". $fname .", \n\nYou have been requested from a Veteran from Vetworking Sysyem .\nClick here to login.\nhttp://vetworking.x10host.com/bootstrap-3.3.6-dist/index.php\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
							$headers = 'From: Veyworking System' . "\r\n" .
											'Reply-To: ' . "\r\n" .
											'X-Mailer: PHP/' . phpversion();
							mail($to, $subject, $message, $headers);
						}
						else{
							echo "Something is wrong!";
						}
					}
					}
					?>

				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped">
						<thead>
						<tr class="info">
							<th> Mentor Name </th>
							<th> First Name </th>
							<th> Last Name </th>
							<th> City </th>
							<th> State </th>
							<th id="center-th"> Action </th>
						</tr>
						</thead>

						<tbody id = "myTable">
						<?php
							include("../dbc.php");
							$q = 'SELECT * FROM users WHERE role = "mentor" AND uname not in (SELECT mentor_name FROM requests WHERE veteran_name = "'.$_SESSION['uname'].'")';
							$r = mysqli_query($dbc, $q);
							//echo '<td><input type="button" id= "'.$row['uname'].'" value="Request" class="mybut btn btn-info btn-mini" style=""></td>';

							while ($row = mysqli_fetch_array($r)){

								echo "<tr>";
									echo "<td>".$row['uname']."</td>";
									echo "<td>".$row['fname']."</td>";
									echo "<td>".$row['lname']."</td>";
									echo "<td>".$row['city']."</td>";
									echo "<td>".$row['state']."</td>";
									echo "<form action='veteran_request_mentor.php' method='POST'>";
									echo '<td id="center-th"><input type = "submit" class="btn btn-info" name = "request" value = "request" />';
									echo '<input type = "hidden" name = "uname" value = "'.$row['uname'].'">';
									echo '<input type = "hidden" name = "email" value = "'.$row['email'].'"/>';
									//<a onClick=\"javascript: return confirm('Do you really want to request this mentor?');\"
									//echo '<td><input type="button" id= "'.$row['uname'].'" value="Request" class="mybut btn btn-info btn-mini" style=""></td>';
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
