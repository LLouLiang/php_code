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

    <title>Registration</title>

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

        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="../index.php">Homepage</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
								<li><a href="../about_us.php">About Us</a></li>
                <li><a href="../contact_us.php">Contact Us</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>

        <div class="jumbotron">

					<?php

						date_default_timezone_set("America/New_York");

						if(empty($_SESSION['role']))
						{
							echo "<script>window.open('../register.php','_self');</script>";
						}
						else{
							$role = 'job_fair_recruiter';
						}

						if ($_SERVER['REQUEST_METHOD'] == 'POST'){

							$uname= $_POST['uname'];
							$psword= $_POST['psword'];
							$psword2= $_POST['psword2'];
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

							if(empty($uname)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to enter Username!
																					</div>";
							if (!empty($uname) && !preg_match("/^[a-zA-Z ]*$/",$uname)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																				 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																				 <span aria-hidden='true'>&times;</span>
																																				 </button>
																																				 <strong>Warning!</strong> Only letters and white space allowed for the Username!
																																				 </div>";
							if(empty($psword)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> You forgot to enter Password!
																					</div>";
							if($psword != $psword2) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																					<span aria-hidden='true'>&times;</span>
																					</button>
																					<strong>Warning!</strong> The Password doesn't match!
																					</div>";
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
							 if(empty($new_resume_size)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to select a Resume!
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

							// if the user has selected an image:
							if( (empty($error)) && (move_uploaded_file($image_loc,$folder.$final_image)) && (move_uploaded_file($resume_loc,$folder.$final_resume)) ) {
							$reg_date = date("y-m-d h:i:s");
								//1. connect to db
								include("../dbc.php");
								//2. define a query (insert record to users table)
								$q = "INSERT INTO users (uname,
																				psword,
																				fname,
																				lname,
																				zip,
																				address,
																				city,
																				state,
																				image,
																				image_type,
																				image_size,
																				resume,
																				resume_type,
																				resume_size,
																				emp_status,
																				industry_work,
																				email,
																				phone,
																				reg_date,
																				role) VALUES
																				('$uname',
																				SHA1('$psword'),
																				'$fname',
																				'$lname',
																				'$zip',
																				'$address',
																				'$city',
																				'$state',
																				'$final_image',
																				'$image_type',
																				'$new_image_size',
																				'$final_resume',
																				'$resume_type',
																				'$new_resume_size',
																				'$emp_status',
																				'$industry_work',
																				'$email',
																				'$phone',
																				'$reg_date',
																				'$role')";
								//3. execute the query
								$r = mysqli_query($dbc, $q);
								//4. sanity check
								if ($r){
									//send confirmation to users email
									echo "<center>you have registered succesfuly, please check your email</center>";
									$to = $email;
									$subject = 'Confirmation to register for Vetworking system';
									$message = "Hi ". $fname .", \n\nregister for Vetworking system .\nClick here to login.\nhttp://vetworking.x10host.com/Vetworking%20System/index.php\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
									$headers = 'From: Vetworking System' . "\r\n" .
												'Reply-To: ' . "\r\n" .
												'X-Mailer: PHP/' . phpversion();
									mail($to, $subject, $message, $headers);
								}
								if ($r && $role == 'job_fair_recruiter'){
									//send confirmation to users email
									echo "<center>you have registered succesfuly, please check your email</center>";
									$to = $email;
									$subject = 'Confirmation to register for Vetworking system';
									$message = "Hi ". $fname .", \n\nregister for Vetworking system .\nClick here to login.\nhttp://vetworking.x10host.com/Vetworking%20System/index.php\n\nYou can start to select job fair\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
									$headers = 'From: Vetworking System' . "\r\n" .
												'Reply-To: ' . "\r\n" .
												'X-Mailer: PHP/' . phpversion();
									mail($to, $subject, $message, $headers);
								}
								if($r){
									echo "<script>window.open('../successfully_registered.php', '_self')</script>";
								}
								else{
									//echo "Something Wrong";
									echo "<div class='alert alert-danger alert-dismissible' role='alert'>
												<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
												<span aria-hidden='true'>&times;</span>
												</button>
												<strong>Warning!</strong> The Username has already exist!
												</div>";
								}
							}
							// if the user didn't select an image:
							else if( (empty($error)) && (empty(move_uploaded_file($image_loc,$folder.$final_image))) && (move_uploaded_file($resume_loc,$folder.$final_resume)) ) {
							$reg_date = date("y-m-d h:i:s");
								//1. connect to db
								include("../dbc.php");
								//2. define a query (insert record to users table)
								$q = "INSERT INTO users (uname,
																				psword,
																				fname,
																				lname,
																				zip,
																				address,
																				city,
																				state,
																				resume,
																				resume_type,
																				resume_size,
																				emp_status,
																				industry_work,
																				email,
																				phone,
																				reg_date,
																				role) VALUES
																				('$uname',
																				SHA1('$psword'),
																				'$fname',
																				'$lname',
																				'$zip',
																				'$address',
																				'$city',
																				'$state',
																				'$final_resume',
																				'$resume_type',
																				'$new_resume_size',
																				'$emp_status',
																				'$industry_work',
																				'$email',
																				'$phone',
																				'$reg_date',
																				'$role')";
								//3. execute the query
								$r = mysqli_query($dbc, $q);
								//4. sanity check
								if ($r){
									//send confirmation to users email
									echo "<center>you have registered succesfuly, please check your email</center>";
									$to = $email;
									$subject = 'Confirmation to register for Vetworking system';
									$message = "Hi ". $fname .", \n\nregister for Vetworking system .\nClick here to login.\nhttp://vetworking.x10host.com/Vetworking%20System/index.php\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
									$headers = 'From: Vetworking System' . "\r\n" .
												'Reply-To: ' . "\r\n" .
												'X-Mailer: PHP/' . phpversion();
									mail($to, $subject, $message, $headers);
								}
								if ($r && $role == 'job_fair_recruiter'){
									//send confirmation to users email
									echo "<center>you have registered succesfuly, please check your email</center>";
									$to = $email;
									$subject = 'Confirmation to register for Vetworking system';
									$message = "Hi ". $fname .", \n\nregister for Vetworking system .\nClick here to login.\nhttp://vetworking.x10host.com/Vetworking%20System/index.php\n\nYou can start to select job fair\n\nThis is a system email. Please do not reply!\n\nThank You!\n\nVetworking System";
									$headers = 'From: Vetworking System' . "\r\n" .
												'Reply-To: ' . "\r\n" .
												'X-Mailer: PHP/' . phpversion();
									mail($to, $subject, $message, $headers);
								}
								if($r){
									echo "<script>window.open('../successfully_registered.php', '_self')</script>";
								}
								else{
									//echo "Something Wrong";
									echo "<div class='alert alert-danger alert-dismissible' role='alert'>
												<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
												<span aria-hidden='true'>&times;</span>
												</button>
												<strong>Warning!</strong> The Username has already exist!
												</div>";
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

					<form action="registration_job_fair_recruiter.php" method="POST" class="form-horizontal" enctype="multipart/form-data">

						<div class='alert alert-info alert-dismissible' role='alert'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
							</button>
							You are registering as a <strong>Job Fair Recruiter</strong>
						</div>

            <!-- username -->
            <div class="form-group">
              <label for="uname" class="col-sm-2 control-label">Username:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="uname" placeholder="Username" name="uname" value =
								<?php if(isset($_POST['uname'])) echo $_POST['uname'] ?>>
              </div>
            </div>
            <!-- /username -->

            <!-- password -->
            <div class="form-group" method="POST">
              <label for="psword" class="col-sm-2 control-label">Password:</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="psword" placeholder="Password" name="psword">
              </div>
            </div>
            <!-- /password -->

            <!-- confirm password -->
            <div class="form-group" method="POST">
              <label for="psword" class="col-sm-2 control-label">Confirm Password:</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="psword2" placeholder="Re-enter the Password" name="psword2">
              </div>
            </div>
            <!-- /confirm password -->

            <!-- firstname -->
            <div class="form-group">
              <label for="fname" class="col-sm-2 control-label">First Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="fname" placeholder="First Name" name="fname" value =
								<?php if(isset($_POST['fname'])) echo $_POST['fname'] ?>>
              </div>
            </div>
            <!-- /firstname -->

            <!-- lastname -->
            <div class="form-group">
              <label for="lname" class="col-sm-2 control-label">Last Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname" value =
								<?php if(isset($_POST['lname'])) echo $_POST['lname'] ?>>
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
								<?php if(isset($_POST['city'])) echo $_POST['city'] ?>>
              </div>
            </div>
            <!-- /city -->

						<!-- address -->
            <div class="form-group">
              <label for="address" class="col-sm-2 control-label">Address:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="address" placeholder="Address" name="address" value =
								<?php if(isset($_POST['address'])) echo $_POST['address'] ?>>
              </div>
            </div>
            <!-- /address -->

            <!-- zip code -->
            <div class="form-group">
              <label for="zip" class="col-sm-2 control-label">Zip code:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="zip" placeholder="Zip Code" name="zip" value =
								<?php if(isset($_POST['zip'])) echo $_POST['zip'] ?>>
              </div>
            </div>
            <!-- /zip code -->

            <!-- email -->
            <div class="form-group">
              <label for="email" class="col-sm-2 control-label">Email:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Email" name="email" value =
								<?php if(isset($_POST['email'])) echo $_POST['email'] ?>>
              </div>
            </div>
            <!-- /email -->

            <!-- phone -->
            <div class="form-group">
              <label for="phone" class="col-sm-2 control-label">Phone:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" value =
								<?php if(isset($_POST['phone'])) echo $_POST['phone'] ?>>
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
							<label for="resume" class="col-sm-2 control-label">Resume:</label>
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
              <label for="industry_work" class="col-sm-2 control-label">Industry Work / have worked:</label>
              <div class="col-sm-10">
                <?php
                  $industry_work=array("IT", "Business", "Health Care");
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

            <!-- register button -->
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success" name="button" value="Register">Register</button>
              </div>
            </div>
            <!-- /register button -->

          <!-- /form -->
          </form>

          <!-- cancel button -->
          <div class="text-center">
            <a  class="btn btn-danger" href="../register.php" role="button">Cancel and go back!</a>
          </div>
          <!-- /cancel button -->
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
