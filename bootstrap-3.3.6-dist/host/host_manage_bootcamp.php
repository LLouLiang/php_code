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

    <title>Manage Boot Camp</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/vs-style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

		<script language="JavaScript">
		<!--
		function validateForm(f) {
		  if (f.value == "") {
		     //alert("Please enter some text into the description field");
		     return false;
		  }
		  else
		     return true;
		  }
		//-->
		</script>

  </head>

  <body>

    <div class="container">
      <div class="row">

        <div clas="col-md-12">
          <h1 id="header" class="text-center">Vetworking System</h1>
        </div>

				<!-- including the host's header -->
				<?php include("../includes/host_header.html"); ?>

				<!-- .jumbotron -->
        <div class="jumbotron">

					<?php
						if (!empty($_SESSION['uname'])){
							$uname = $_SESSION['uname'];
						}
						else{
							echo "<script>window.open('../index.php','_self');</script>";
						}
						?>

					<?php
						if (isset($_SESSION['bc_id']))
							$bc_id = $_SESSION['bc_id'];
						else if (isset($_POST['bc_id']))
							$bc_id = $_POST['bc_id'];
						else
							echo "invalid access.";

						if ($_SERVER['REQUEST_METHOD'] == 'POST') {

							$bc_title= $_POST['bc_title'];
							$bc_description= $_POST['bc_description'];
							//$bc_startdate= $_POST['bc_startdate'];
							$bc_startdate = date("Y-m-d", strtotime($_POST['bc_startdate']) );
							//$bc_enddate= $_POST['bc_enddate'];
							$bc_enddate = date("Y-m-d", strtotime($_POST['bc_enddate']) );
							$bc_time = $_POST['bc_time'];
							$bc_location = $_POST['bc_location'];

							// To get the difference bewtween the start date and the end date
							//$bc_startdate2 = $bc_startdate;
							$bc_startdate2 = date_create($_POST['bc_startdate']);
							//$bc_enddate2 = $bc_enddate;
 							$bc_enddate2 = date_create($_POST['bc_enddate']);
 							$interval = date_diff($bc_startdate2, $bc_enddate2);
 							$different_date = $interval->format('%R%a days');

							//define an array of error
							$error = array();

							if(empty($bc_title)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																							<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																							<span aria-hidden='true'>&times;</span>
																							</button>
																							<strong>Warning!</strong> You forgot to enter a Title!
																							</div>";
							// check if name only contains letters and whitespace
							if (!empty($bc_title) && !preg_match("/^[a-zA-Z ]*$/",$bc_title)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																													 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																													 <span aria-hidden='true'>&times;</span>
																																													 </button>
																																													 <strong>Warning!</strong> Only letters and white space allowed for the Title!
																																													 </div>";
						 if(empty($bc_description)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																									 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																									 <span aria-hidden='true'>&times;</span>
																									 </button>
																									 <strong>Warning!</strong> You forgot to enter Description!
																									 </div>";
						 if(empty($bc_startdate)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																								<span aria-hidden='true'>&times;</span>
																								</button>
																								<strong>Warning!</strong> You forgot to select the Start Date!
																								</div>";
						 if(empty($bc_enddate)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																							<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																							<span aria-hidden='true'>&times;</span>
																							</button>
																							<strong>Warning!</strong> You forgot to select the End Date!
																							</div>";
						 if(!empty($bc_startdate) && !empty($bc_enddate) && ($different_date != '+2 days')) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
 																																																	<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
 																																																	<span aria-hidden='true'>&times;</span>
 																																																	</button>
 																																																	<strong>Warning!</strong> You can select Only 3 days to host a Boot Camp!
 																																																	</div>";
						 if(empty($bc_time)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to enter a Time!
																						</div>";
							// check if name only time format (eg. 18:17 or 6:17pm)
							if (!empty($bc_time) && !preg_match("/^\d{1,2}:\d{2}([ap]m)?$/",$bc_time)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																													 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																													 <span aria-hidden='true'>&times;</span>
																																													 </button>
																																													 <strong>Warning!</strong> Wrong format for the for the Time!
																																													 </div>";
						 if(empty($bc_location)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																								<span aria-hidden='true'>&times;</span>
																								</button>
																								<strong>Warning!</strong> You forgot to enter a Location!
																								</div>";
							// check if name only contains letters and whitespace
							if (!empty($bc_location) && !preg_match("/^[a-zA-Z ]*$/",$bc_location)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																																	 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																																	 <span aria-hidden='true'>&times;</span>
																																																	 </button>
																																																	 <strong>Warning!</strong> Only letters and white space allowed for the Location!
																																																	 </div>";

							 if(empty($error)){
	 								//1. connect to db
	 								include("../dbc.php");
	 								$q1 = "SELECT DATEDIFF('$bc_startdate',NOW()) AS DiffDate";
	 								$r1 = mysqli_query($dbc, $q1);

	 							if($r1)
	 							{
 									  $row = mysqli_fetch_array($r1);
 										$diff = $row['DiffDate'];

	 								if($diff <= 0)
	 								{
	 									echo "<div class='alert alert-danger alert-dismissible' role='alert'>
	 												<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	 												<span aria-hidden='true'>&times;</span>
	 												</button>
	 												<strong>Warning!</strong> You cannot select today or a date before today as a start date for the boot camp!
	 												</div>";
	 								}
	 								else
	 								{
	 									//2. define a query (insert record to users table)
										$q = "UPDATE bootcamps SET bc_title = '$bc_title',
																		bc_description = '$bc_description',
																		bc_startdate = '$bc_startdate',
																		bc_enddate = '$bc_enddate',
																		bc_time = '$bc_time',
																		bc_location = '$bc_location'
																		WHERE bc_id = '$bc_id'";

	 									//3. execute the query
	 									$r = mysqli_query($dbc, $q);
	 									//4. sanity check
	 									if($r){
											echo "<script>window.open('host_manage_bootcamps.php','_self');</script>";
	 									}
	 									else{
	 										echo "Something Wrong";
	 									}
	 								}
	 							}
	 						}
	 						else{
	 							//print error information
	 							foreach ($error as $err){
	 								echo $err;
	 								//echo "<br>";
	 							}
	 						}

						}
					?>

					<form action="" method="POST" class="form-horizontal"  onSubmit="validateForm(host_create_bootcamp.description)">

						<?php
							//connect to database
							include("../dbc.php");

							$q = "SELECT * FROM bootcamps WHERE bc_id= '$bc_id'";

							$r = mysqli_query($dbc, $q);

							while ($row = mysqli_fetch_array($r)){
									$db_bc_title = $row['bc_title'];
									$db_bc_description = $row['bc_description'];
									$db_bc_startdate = $row['bc_startdate'];
									$db_bc_enddate = $row['bc_enddate'];
									$db_bc_time = $row['bc_time'];
									$db_bc_location = $row['bc_location'];
							}
						?>

						<!-- boot camp title -->
						<div class="form-group">
							<label for="bc_title" class="col-sm-2 control-label">Title:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="bc_title" placeholder="Title" name="bc_title" value =
								<?php echo $db_bc_title; ?> >
							</div>
						</div>
						<!-- /boot camp title -->

						<!-- boot camp description -->
						<div class="form-group">
							<label for="bc_description" class="col-sm-2 control-label">Description:</label>
							<div class="col-sm-10"> <!-- Choose the default size, it was full "10" -->
								<textarea class="form-control" rows="3" id="bc_description" placeholder="Description" name="bc_description"><?php echo $db_bc_description; ?></textarea>
							</div>
						</div>
						<!-- /boot camp description -->

						<!-- start date -->
						<div class="form-group">
							<label for="bc_startdate" class="col-sm-2 control-label">Start Date:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="startPicker" placeholder="Start Date" name="bc_startdate" value =
								<?php echo $db_bc_startdate; ?> >
							</div>
						</div>
						<!-- /start date -->

						<!-- end date -->
						<div class="form-group">
							<label for="bc_enddate" class="col-sm-2 control-label">End Date:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="endPicker" placeholder="End Date" name="bc_enddate" value =
								<?php echo $db_bc_enddate; ?> >
							</div>
						</div>
						<!-- /end date -->

						<!-- boot camp time -->
						<div class="form-group">
							<label for="bc_time" class="col-sm-2 control-label">Time:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="bc_time" placeholder="Time" name="bc_time" value =
								<?php echo $db_bc_time; ?> >
							</div>
						</div>
						<!-- /boot camp time -->

						<!-- boot camp location -->
						<div class="form-group">
							<label for="bc_location" class="col-sm-2 control-label">Location:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="bc_location" placeholder="Location" name="bc_location" value =
								<?php echo $db_bc_location; ?> >
							</div>
						</div>
						<!-- /boot camp location -->

						<!-- update button -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-warning" name="edit" value="Update">Update</button>
							</div>
						</div>
						<!-- /update button -->

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

		<!-- jQuery date picker -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.datepick.css">
		<script type="text/javascript" src="../js/jquery/jquery.plugin.js"></script>
		<script type="text/javascript" src="../js/jquery/jquery.datepick.js"></script>
		<script>
			$('#startPicker,#endPicker').datepick({
			    onSelect: customRange, showTrigger: '#calImg'});
			function customRange(dates) {
			    if (this.id == 'startPicker') {
			        $('#endPicker').datepick('option', 'minDate', dates[0] || null);
			    }
			    else {
			        $('#startPicker').datepick('option', 'maxDate', dates[0] || null);
			    }
			}
		</script>
		<!-- /jQuery date picker -->

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>

  </body>

</html>
