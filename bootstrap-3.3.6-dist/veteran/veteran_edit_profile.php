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

    <title>Edit Profile</title>

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

				<!-- including the veteran's header -->
				<?php include("../includes/veteran_header.html"); ?>

				<!-- .jumbotron -->
        <div class="jumbotron">

					<?php
						if( (empty($_SESSION['uname'])) || ($_SESSION['role'] != 'veteran') )
						{
							echo "<script>window.open('../index.php','_self');</script>";
						}
						else{
							$uname = $_SESSION['uname'];
						}

						//retrieve session data
						$uname = $_SESSION['uname'];
						$fname = $_SESSION['fname'];

						if (isset($_GET['role'])) $role = $_GET['role'];

						if ($_SERVER['REQUEST_METHOD'] == 'POST'){

							$fname= $_POST['fname'];
							$lname= $_POST['lname'];
							$email= $_POST['email'];
							$phone= $_POST['phone'];
							$state= $_POST['state'];
							$emp_status= $_POST['emp_status'];
							$industry_work= $_POST['industry_work'];
							$city= $_POST['city'];
							$zip= $_POST['zip'];
							$address= $_POST['address'];

							$industry_interested= $_POST['industry_interested'];
							$veteran_date_became= $_POST['veteran_date_became'];

							$image = rand(1000,100000)."-".$_FILES['image']['name'];
							$image_loc = $_FILES['image']['tmp_name'];
							$image_size = $_FILES['image']['size'];
							$image_type = $_FILES['image']['type'];
							$folder="../uploads/";
							// new image size in KB
							$new_image_size = $image_size/1024;
							// make image name in lower case
							$new_image_name = strtolower($image);
							// make image name in lower case
							$final_image=str_replace(' ','-',$new_image_name);

							$resume = rand(1000,100000)."-".$_FILES['resume']['name'];
							$resume_loc = $_FILES['resume']['tmp_name'];
							$resume_size = $_FILES['resume']['size'];
							$resume_type = $_FILES['resume']['type'];
							$folder="../uploads/";
							// new resume size in KB
							$new_resume_size = $resume_size/1024;
							// make resume name in lower case
							$new_resume_name = strtolower($resume);
							// make resume name in lower case
							$final_resume=str_replace(' ','-',$new_resume_name);

							// validate data
							$error = array();

							if(empty($fname)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to enter First Name!
																					</div>";
							if (!empty($fname) && !preg_match("/^[a-zA-Z ]*$/",$fname)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																										 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																										 <span aria-hidden='true'>&times;</span>
																																										 </button>
																																										 <strong>Warning!</strong> Only letters and white space allowed for the First Name!
																																										 </div>";
							if(empty($lname)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to enter Last Name!
																					</div>";
							if (!empty($lname) && !preg_match("/^[a-zA-Z ]*$/",$lname)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																										 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																										 <span aria-hidden='true'>&times;</span>
																																										 </button>
																																										 <strong>Warning!</strong> Only letters and white space allowed for the Last Name!
																																										 </div>";
							if(empty($zip)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																				<span aria-hidden='true'>&times;</span>
																				</button>
																				<strong>Warning!</strong> You forgot to enter Zip Code!
																				</div>";
							if (!empty($zip) && !preg_match("/^[0-9]{5}([- ]?[0-9]{4})?$/",$zip)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																															 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																															 <span aria-hidden='true'>&times;</span>
																																															 </button>
																																															 <strong>Warning!</strong> Invalid Zip Code Format!
																																															 </div>";
							if(empty($address)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to enter Address!
																						</div>";
							if(empty($city)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to enter City!
																					</div>";
							if (!empty($city) && !preg_match("/^[a-zA-Z ]*$/",$city)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																									 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																									 <span aria-hidden='true'>&times;</span>
																																									 </button>
																																									 <strong>Warning!</strong> Only letters and white space allowed for the City!
																																									 </div>";
							if(empty($state)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to select State!
																					</div>";
							if(empty($emp_status)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																								<span aria-hidden='true'>&times;</span>
																								</button>
																								<strong>Warning!</strong> You forgot to select Employment Status!
																								</div>";
							if(empty($industry_work)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																									<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																									<span aria-hidden='true'>&times;</span>
																									</button>
																									<strong>Warning!</strong> You forgot to select Industry!
																									</div>";
							if(empty($email)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to enter Email!
																					</div>";
							if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																													 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																													 <span aria-hidden='true'>&times;</span>
																																													 </button>
																																													 <strong>Warning!</strong> Invalid Email Format!
																																													 </div>";
							if(empty($phone)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to enter Phone Number!
																					</div>";
							if (!empty($phone) && !preg_match("/^[2-9]\d{2}\d{3}\d{4}$/",$phone)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																															 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																															 <span aria-hidden='true'>&times;</span>
																																															 </button>
																																															 <strong>Warning!</strong> Invalid Phone Number Format!
																																															 </div>";
							if(empty($industry_interested)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to select Industry!
																					</div>";
							if(empty($veteran_date_became)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to select a Date!
																					</div>";
 						 if( !empty($resume_type) && $resume_type != 'application/pdf') $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
 																				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
 																				<span aria-hidden='true'>&times;</span>
 																				</button>
 																				<strong>Warning!</strong> You can Only select a PDF format for the Resume!
 																				</div>";
 						 if( !empty($image_type) && $image_type != 'image/jpeg') $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
 																				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
 																				<span aria-hidden='true'>&times;</span>
 																				</button>
 																				<strong>Warning!</strong> You can Only select a JPEG format for the Image!
 																				</div>";

						// if the user has selected a resume & an image:
						if( (empty($error)) && (move_uploaded_file($image_loc,$folder.$final_image)) && (move_uploaded_file($resume_loc,$folder.$final_resume)) ) {
								//connect to database
								include("../dbc.php");
								//define a query
								$q = "UPDATE users SET fname = '$fname',
																			 lname = '$lname',
																	 		 zip = '$zip',
																			 address = '$address',
																			 city = '$city',
																			 state = '$state',
																			 email = '$email',
																			 emp_status = '$emp_status',
																			 industry_work = '$industry_work',
																			 phone = '$phone',
																			 image = '$final_image',
																			 image_type = '$image_type',
																			 image_size = '$new_image_size',
																			 resume = '$final_resume',
																			 resume_type = '$resume_type',
																			 resume_size = '$new_resume_size',
																			 industry_interested = '$industry_interested',
																			 veteran_date_became = '$veteran_date_became'
																			 WHERE uname = '$uname' ";
								//excute the query
								$r = mysqli_query($dbc, $q);
								if ($r){
									echo "<script>window.open('successfully_updated_profile.php', '_self')</script>";
								}
								else{
								//echo " Error!";
							}
						}
						// if the user has selected a resume & didn't select an image:
						else if( (empty($error)) && (empty(move_uploaded_file($image_loc,$folder.$final_image))) && (move_uploaded_file($resume_loc,$folder.$final_resume)) ) {
								//connect to database
								include("../dbc.php");
								//define a query
								$q = "UPDATE users SET fname = '$fname',
																			 lname = '$lname',
																			 zip = '$zip',
																			 address = '$address',
																			 city = '$city',
																			 state = '$state',
																			 email = '$email',
																			 emp_status = '$emp_status',
																			 industry_work = '$industry_work',
																			 phone = '$phone',
																			 resume = '$final_resume',
																			 resume_type = '$resume_type',
																			 resume_size = '$new_resume_size',
																			 industry_interested = '$industry_interested',
																			 veteran_date_became = '$veteran_date_became'
																			 WHERE uname = '$uname' ";
								//excute the query
								$r = mysqli_query($dbc, $q);
								if ($r){
									echo "<script>window.open('successfully_updated_profile.php', '_self')</script>";
								}
								else{
								//echo " Error!";
							}
						}
						// if the user has selected an image & didn't select a resume:
						else if( (empty($error)) && (move_uploaded_file($image_loc,$folder.$final_image)) && (empty(move_uploaded_file($resume_loc,$folder.$final_resume))) ) {
								//connect to database
								include("../dbc.php");
								//define a query
								$q = "UPDATE users SET fname = '$fname',
																			 lname = '$lname',
																			 zip = '$zip',
																			 address = '$address',
																			 city = '$city',
																			 state = '$state',
																			 email = '$email',
																			 emp_status = '$emp_status',
																			 industry_work = '$industry_work',
																			 phone ='$phone',
																			 image = '$final_image',
																			 image_type = '$image_type',
																			 image_size = '$new_image_size',
																			 industry_interested = '$industry_interested',
																			 veteran_date_became = '$veteran_date_became'
																			 WHERE uname = '$uname' ";
								//excute the query
								$r = mysqli_query($dbc, $q);
								if ($r){
									echo "<script>window.open('successfully_updated_profile.php', '_self')</script>";
								}
								else{
								//echo " Error!";
							}
						}
						// if the user didn't select a resume & didn't select an image:
						else if( (empty($error)) && (empty(move_uploaded_file($image_loc,$folder.$final_image))) && (empty(move_uploaded_file($resume_loc,$folder.$final_resume))) ) {
								//connect to database
								include("../dbc.php");
								//define a query
								$q = "UPDATE users SET fname = '$fname',
																			 lname = '$lname',
																			 zip = '$zip',
																			 address = '$address',
																			 city = '$city',
																			 state = '$state',
																			 email = '$email',
																			 emp_status = '$emp_status',
																			 industry_work = '$industry_work',
																			 phone = '$phone',
																			 industry_interested = '$industry_interested',
																			 veteran_date_became = '$veteran_date_became'
																			 WHERE uname = '$uname' ";
								//excute the query
								$r = mysqli_query($dbc, $q);
								if ($r){
									echo "<script>window.open('successfully_updated_profile.php', '_self')</script>";
								}
								else{
								//echo " Error!";
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

          <form action="veteran_edit_profile.php" method="POST" class="form-horizontal" enctype="multipart/form-data">

						<!-- this query to get all the values from the db -->
						<?php
							//connect to database
							include("../dbc.php");
							$q = "SELECT * FROM users WHERE uname = '$uname'";
							$r = mysqli_query($dbc, $q);
							while ($row = mysqli_fetch_array($r)){
									// we save each row from the db in a new value, and echo the value inside its field
									$db_fname = $row['fname'];
									$db_lname = $row['lname'];
									$db_address = $row['address'];
									$db_city = $row['city'];
									$db_state = $row['state'];
									$db_zip = $row['zip'];
									$db_email = $row['email'];
									$db_phone = $row['phone'];
									$db_emp_status = $row['emp_status'];
									$db_industry_work = $row['industry_work'];

									$db_industry_interested = $row['industry_interested'];
									$db_veteran_date_became = $row['veteran_date_became'];
							}
						?>

            <!-- firstname -->
            <div class="form-group">
              <label for="fname" class="col-sm-2 control-label">First Name:</label>
              <div class="col-sm-10">
								<input type="text" class="form-control" id="fname" placeholder="First Name" name="fname" value =
								<?php echo $db_fname; ?> >
              </div>
            </div>
            <!-- /firstname -->

            <!-- lastname -->
            <div class="form-group">
              <label for="lname" class="col-sm-2 control-label">Last Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname" value =
								<?php echo $db_lname; ?> >
              </div>
            </div>
            <!-- /lastname -->

						<!-- state -->
						<div class="form-group">
							<label for="state" class="col-sm-2 control-label">State:</label>
							<div class="col-sm-10">
								<?php
									$state=array(
										'AL'=>'Alabama',
										'AK'=>'Alaska',
										'AZ'=>'Arizona',
										'AR'=>'Arkansas',
										'CA'=>'California',
										'CO'=>'Colorado',
										'CT'=>'Connecticut',
										'DE'=>'Delaware',
										'DC'=>'District of Columbia',
										'FL'=>'Florida',
										'GA'=>'Georgia',
										'HI'=>'Hawaii',
										'ID'=>'Idaho',
										'IL'=>'Illinois',
										'IN'=>'Indiana',
										'IA'=>'Iowa',
										'KS'=>'Kansas',
										'KY'=>'Kentucky',
										'LA'=>'Louisiana',
										'ME'=>'Maine',
										'MD'=>'Maryland',
										'MA'=>'Massachusetts',
										'MI'=>'Michigan',
										'MN'=>'Minnesota',
										'MS'=>'Mississippi',
										'MO'=>'Missouri',
										'MT'=>'Montana',
										'NE'=>'Nebraska',
										'NV'=>'Nevada',
										'NH'=>'New Hampshire',
										'NJ'=>'New Jersey',
										'NM'=>'New Mexico',
										'NY'=>'New York',
										'NC'=>'North Carolina',
										'ND'=>'North Dakota',
										'OH'=>'Ohio',
										'OK'=>'Oklahoma',
										'OR'=>'Oregon',
										'PA'=>'Pennsylvania',
										'RI'=>'Rhode Island',
										'SC'=>'South Carolina',
										'SD'=>'South Dakota',
										'TN'=>'Tennessee',
										'TX'=>'Texas',
										'UT'=>'Utah',
										'VT'=>'Vermont',
										'VA'=>'Virginia',
										'WA'=>'Washington',
										'WV'=>'West Virginia',
										'WI'=>'Wisconsin',
										'WY'=>'Wyoming',
									);
									echo '<select class="form-control" name="state">';
									foreach($state as $st){
										echo '<option value="'.$st.'"';
											if($st==$_POST['state']) echo 'selected = "selected"';
										echo '>'.$st.'</option>';
									}
									echo '</select>';
								?>
							</div>
						</div>
						<!-- /state -->

						<!-- city -->
            <div class="form-group">
              <label for="city" class="col-sm-2 control-label">City:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="city" placeholder="City" name="city" value =
								<?php echo $db_city; ?> >
              </div>
            </div>
            <!-- /city -->

            <!-- address -->
            <div class="form-group">
              <label for="address" class="col-sm-2 control-label">Address:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="address" placeholder="Address" name="address" value =
								<?php echo $db_address; ?> >
              </div>
            </div>
            <!-- /address -->

            <!-- zip code -->
            <div class="form-group">
              <label for="zip" class="col-sm-2 control-label">Zip code:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="zip" placeholder="Zip Code" name="zip" value =
								<?php echo $db_zip; ?> >
              </div>
            </div>
            <!-- /zip code -->

            <!-- email -->
            <div class="form-group">
              <label for="email" class="col-sm-2 control-label">Email:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Email" name="email" value =
								<?php echo $db_email; ?> >
              </div>
            </div>
            <!-- /email -->

            <!-- phone -->
            <div class="form-group">
              <label for="phone" class="col-sm-2 control-label">Phone:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" value =
								<?php echo $db_phone; ?> >
              </div>
            </div>
            <!-- /phone -->

						<!-- image -->
						<div class="form-group">
							<label for="image" class="col-sm-2 control-label"><span class="label label-warning">Optional</span> Image:</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="image" placeholder="Image" name="image" />
							</div>
						</div>
						<!-- /image -->

						<!-- resume -->
						<div class="form-group">
							<label for="resume" class="col-sm-2 control-label"><span class="label label-warning">Optional</span> Resume:</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="resume" placeholder="Resume" name="resume" />
							</div>
						</div>
						<!-- /resume -->

            <!-- employment status -->
            <div class="form-group">
              <label for="emp_status" class="col-sm-2 control-label">Employment Status:</label>
              <div class="col-sm-10">
                <?php
                  $emp_status=array("Employee", "Non employee");
                  echo '<select class="form-control" name="emp_status">';
                  foreach($emp_status as $emp){
                    echo '<option value="'.$emp.'"';
                      if($emp==$_POST['emp_status']) echo 'selected = "selected"';
                    echo '>'.$emp.'</option>';
                  }
                  echo '</select>';
                ?>
              </div>
            </div>
            <!-- /employment status -->

						<!-- industry_work -->
            <div class="form-group">
              <label for="industry_work" class="col-sm-2 control-label">Industry of your work:</label>
              <div class="col-sm-10">
                <?php
                  $industry_work=array("IT", "Business", "Healt Care");
                  echo '<select class="form-control" name="industry_work">';
                  foreach($industry_work as $ind){
                    echo '<option value="'.$ind.'"';
                      if($ind==$_POST['industry_work']) echo 'selected = "selected"';
                    echo '>'.$ind.'</option>';
                  }
                  echo '</select>';
                ?>
              </div>
            </div>
            <!-- /industry_work -->

						<!-- date became a Veteran -->
						<div class="form-group">
							<label for="veteran_date_became" class="col-sm-2 control-label">Date you became a Veteran:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="startPicker" placeholder="Approximate Date" name="veteran_date_became" value =
								<?php echo $db_veteran_date_became; ?> >
							</div>
						</div>
						<!-- /date became a Veteran -->

						<!-- industry_interested -->
						<div class="form-group">
							<label for="industry_interested" class="col-sm-2 control-label">Industries you’re interested in:</label>
							<div class="col-sm-10">
								<?php
									$industry_interested=array("IT", "Business", "Healt Care");
									echo '<select class="form-control" name="industry_interested">';
									foreach($industry_interested as $inds){
										echo '<option value="'.$inds.'"';
											if($inds==$_POST['industry_interested']) echo 'selected = "selected"';
										echo '>'.$inds.'</option>';
									}
									echo '</select>';
								?>
							</div>
						</div>
						<!-- /industry_interested -->

            <!-- register button -->
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-warning" name="button" value="Change">Change</button>
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
