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

    <title>Manage Veterans</title>

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
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$rid = $_POST['request_id'];
				$email = $_POST['email'];
				$fname = $_POST['fname'];
 			//connect to database
 			include("../dbc.php");
			$delete = "DELETE FROM requests WHERE request_id='$rid'";
			$z= mysqli_query($dbc, $delete);
			if($z){
			echo "<div class='alert alert-warning alert-dismissible' role='alert'>
					 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					 <span aria-hidden='true'>&times;</span>
					 </button>
					 <strong>Warning!</strong> You have successfully dropped the veteran!
					 </div>";
				$to = $email;
				$subject = 'You have been dropped by a mentor';
				$message = "Hi ". $fname .", \n\nYou have been dropped from a Mentor from Vetworking Sysyem .\nClick here to login.\nhttp://vetworking.x10host.com/bootstrap-3.3.6-dist/index.php\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
				$headers = 'From: Veyworking System' . "\r\n" .
								'Reply-To: ' . "\r\n" .
								'X-Mailer: PHP/' . phpversion();
				mail($to, $subject, $message, $headers);}
				else{
					echo "Something is wrong";
				}
			}

		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped">
				<thead>
				<tr class="info">
					<th> Veteran Name </th>
					<th> First Name </th>
					<th> Last Name </th>
					<th> Address </th>
					<th> City </th>
					<th> State </th>
					<th> Zip Code </th>
					<th> Email </th>
					<th> Phone </th>
					<th id="center-th"> Action </th>
				</tr>
				</thead>
				<tbody id = "myTable">
				<?php
					//connect to database
					include("../dbc.php");
					$q = "SELECT * FROM requests INNER JOIN users ON requests.veteran_name = users.uname WHERE (requests.mentor_name = '$_SESSION[uname]' AND requests.status = 'approved')";
					$r = mysqli_query($dbc, $q);
					if($r){
					while ($row = mysqli_fetch_array($r)){
						echo "<form action='mentor_manage_veteran.php' method='POST'>";
						echo "<tr>";
							echo "<td>".$row['veteran_name']."</td>";
							echo "<td>".$row['fname']."</td>";
							echo "<td>".$row['lname']."</td>";
							echo "<td>".$row['address']."</td>";
							echo "<td>".$row['city']."</td>";
							echo "<td>".$row['state']."</td>";
							echo "<td>".$row['zip']."</td>";
							echo "<td>".$row['email']."</td>";
							echo "<td>".$row['phone']."</td>";
							echo '<input type = "hidden" name = "request_id" value = "'.$row['request_id'].'">';
							echo '<input type = "hidden" name = "email" value = "'.$row['email'].'">';
							echo '<td id="center-th"><input type = "submit" class="btn btn-warning" name = "drop" value = "drop" />';
							echo '<input type = "hidden" name = "fname" value = "'.$row['fname'].'">';
							echo '</td>';
						echo "</tr>";
						echo "</form>";}
					}
					else{
						echo "Something is wrong";
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
