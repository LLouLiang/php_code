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

    <title>Manage Requests</title>

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

			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['decline'])) {
				$uname = $_POST['uname'];
			$rid = $_POST['request_id'];
			$sender_name = $_POST['veteran_name'];

 			//connect to database
 			include("../dbc.php");
            // Change the conditions
			$update = "DELETE FROM requests WHERE request_id='$rid'";
			$z= mysqli_query($dbc, $update);
			$q = "SELECT email,fname FROM users WHERE uname = '$sender_name'";
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
					 <strong>Warning!</strong> You have successfully declined the request!
					 </div>";

				$to = $email;
				$subject = 'You have been declined by a mentor';
				$message = "Hi ". $fname .", \n\nYou have been declined from a Mentor from Vetworking Sysyem .\nClick here to login.\nhttp://vetworking.x10host.com/bootstrap-3.3.6-dist/index.php\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
				$headers = 'From: Veyworking System' . "\r\n" .
								'Reply-To: ' . "\r\n" .
								'X-Mailer: PHP/' . phpversion();
				mail($to, $subject, $message, $headers);
			}

		?>

		<?php
			$uname = "";

			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
				$uname = $_POST['uname'];
				$rid = $_POST['request_id'];
				$sender_name = $_POST['veteran_name'];

 			//connect to database
 			include("../dbc.php");

			$update2 = "UPDATE requests SET status='approved' WHERE request_id='$rid'";

			$zz= mysqli_query($dbc, $update2);
			$q1 = "SELECT email,fname FROM users WHERE uname = '$sender_name'";
			$r1 = mysqli_query($dbc, $q1);
			if (mysqli_num_rows($r1) == 1){
					$row = mysqli_fetch_array($r1);
					$email1 = $row['email'];
					$fname = $row['fname'];
				}

			echo "<div class='alert alert-success alert-dismissible' role='alert'>
					 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					 <span aria-hidden='true'>&times;</span>
					 </button>
					 <strong>Warning!</strong> You have successfully approved the request!
					 </div>";
				$to = $email1;
				$subject = 'You have been approved by a mentor';
				$message = "Hi ". $fname .", \n\nYou have been approved from a Mentor from Vetworking Sysyem .\nClick here to login.\nhttp://vetworking.x10host.com/bootstrap-3.3.6-dist/index.php\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
				$headers = 'From: Veyworking System' . "\r\n" .
								'Reply-To: ' . "\r\n" .
								'X-Mailer: PHP/' . phpversion();
				mail($to, $subject, $message, $headers);
			}

		?>

		<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
					<tr class="info">
					<th> Sender Name </th>
					<th> Status </th>
					<th colspan="2" id="center-th"> Action </th>
					</tr>
					</thead>
				<tbody id = "myTable">
				<?php
					//connect to database
					include("../dbc.php");
					$q = "SELECT * FROM requests WHERE activity = 'request' AND status = 'waiting' AND mentor_name = '$_SESSION[uname]'";
					$r = mysqli_query($dbc, $q);

					while ($row = mysqli_fetch_array($r)){
						echo "<form action='mentor_manage_requests.php' method='POST'>";
						echo "<tr>";
							echo "<td>".$row['veteran_name']."</td>";
							echo "<td>".$row['status']."</td>";
							echo '<td id="center-th"><input type = "submit" class="btn btn-info" name = "approve" value = "Approve" />';
							echo '</td>';
							echo '<td id="center-th"><input type = "submit" class="btn btn-info" name = "decline" value = "decline" />';
							echo '</td>';
							echo '<input type = "hidden" name = "request_id" value = "'.$row['request_id'].'">';
							echo '<input type = "hidden" name = "veteran_name" value = "'.$row['veteran_name'].'">';
						echo "</tr>";
						echo "</form>";
					}
				?>
				</tbody>

			</table> <!-- /table -->
			</div> <!-- /table-responsive -->

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
