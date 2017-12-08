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

    <title>Manage Boot Camps</title>

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

				<!-- including the host's header -->
				<?php include("../includes/host_header.html"); ?>

				<?php

					if( (empty($_SESSION['uname'])) || ($_SESSION['role'] != 'host') )
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

			$bc_title = "";
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit']))
			{
				$bc_title = $_POST['bc_title'];
				$bc_id = $_POST['bc_id'];

				include("../dbc.php");

				$bc_startdate = ($_POST['bc_startdate']);

				$q1 = "SELECT DATEDIFF('$bc_startdate', NOW()) AS DiffDate from bootcamps where bc_id = '$bc_id'";
				$r1 = mysqli_query($dbc, $q1);
				if($r1)
				{
				while ($row = mysqli_fetch_array($r1)){
					//echo '<p>'.$row['DiffDate'].'</p>';
					$diff = $row['DiffDate'];
				}
				if($diff <= 30)
				{
					echo "<div class='alert alert-danger alert-dismissible' role='alert'>
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
								</button>
								<strong>Warning!</strong> You cannot edit or delete the boot camp within 30 days!
								</div>";
				}
				else
				{
					$_SESSION['bc_id'] = $bc_id;
				echo "<script>window.open('host_manage_bootcamp.php', '_self')</script>";

				}
			}
			else
			{
				echo "error";
			}

			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
				$bc_title = $_POST['bc_title'];
				$bc_id = $_POST['bc_id'];
				include("../dbc.php");
				$bc_startdate = ($_POST['bc_startdate']);
				$q1 = "SELECT DATEDIFF('$bc_startdate', NOW()) AS DiffDate from bootcamps where bc_id = '$bc_id'";
				$r1 = mysqli_query($dbc, $q1);
				if($r1)
				{
				while ($row = mysqli_fetch_array($r1)){
					//echo '<p>'.$row['DiffDate'].'</p>';
					$diff = $row['DiffDate'];
				}
				if($diff <= 30)
				{
					echo "<div class='alert alert-danger alert-dismissible' role='alert'>
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
								</button>
								<strong>Warning!</strong> You cannot edit or delete the boot camp within 30 days!
								</div>";
				}
				else
				{
					$delete = "DELETE FROM bootcamps WHERE bc_id = '$bc_id'";

					$z= mysqli_query($dbc, $delete);

					if ($z) {
						echo "<div class='alert alert-success alert-dismissible' role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
									</button>
									<strong>Warning!</strong> You have successfully deleted the boot camp!
									</div>";
					}
					else
						echo "something wrong";
				}
			}
				else{echo "error";}



				//$today = date("Y/m/d");
				//$today1 = date_create($today);
				//$interval = date_diff($bc_startdate, $today1);
				//$different_date = $interval->format('%R%a days');
				//echo $different_date;


				// The difference between the start date & end date must be only 3 days!
				//if($different_date == '-16 days'){
					//echo "<div class='alert alert-danger alert-dismissible' role='alert'>
				// 																		 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				// 																		 <span aria-hidden='true'>&times;</span>
				// 																		 </button>
				// 																		 <strong>Warning!</strong> You cannot edit or delete this Boot Camp!
				// 																		 </div>";
				// }
				// else{
				// 	echo "OK";
				// }


 			//connect to database
			}

		?>

					<p>Here is a list of the boot camps that you have created with all their information:</p>

					<!-- To make the table scroll horizontally on small devices -->
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
							<tr class="info">
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

								$q = "SELECT * FROM bootcamps WHERE bc_host_name = '$uname'";

								$r = mysqli_query($dbc, $q);

								while ($row = mysqli_fetch_array($r)){

									echo "<tr>";
										echo "<td>".$row['bc_title']."</td>";
										echo "<td>".$row['bc_description']."</td>";
										echo "<td>".$row['bc_startdate']."</td>";
										echo "<td>".$row['bc_enddate']."</td>";
										echo "<td>".$row['bc_time']."</td>";
										echo "<td>".$row['bc_location']."</td>";
										echo "<form action='host_manage_bootcamps.php' method='POST'>";
										echo '<input type = "hidden" name = "bc_id" value = "'.$row['bc_id'].'">';
										echo '<input type = "hidden" name = "bc_startdate" value = "'.$row['bc_startdate'].'">';
										echo '<td id="center-th"><input type = "submit" class="btn btn-info" name = "edit" value = "Edit" />';
										echo '<td id="center-th"><input type = "submit" class="btn btn-danger" name = "delete" value = "Delete" />';
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
