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

    <title>Contact Us</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/vs-style.css" rel="stylesheet">

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
		     //alert("Please enter some text into the comments field");
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
              <a class="navbar-brand" href="index.php">Homepage</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
								<li><a href="about_us.php">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>

        <div class="jumbotron">

					<address>
					  <strong>MITRE Business Strategist.</strong><br>
					  7515 Colshire Drive<br>
					  McLean, VA 22102-7539<br>
					  <abbr title="Phone">P:</abbr> (703) 983-6000
					</address>

					<?php

						// check the submission
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							if($_POST['submit']=='Send') {
								$name= $_POST['name'];
								$email= $_POST['email'];
								$comments= $_POST['comments'];
								$error = array();

								if(empty($name)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to enter Name!
																						</div>";

								// check if name only contains letters and whitespace
								if ( !empty($name) && !preg_match("/^[a-zA-Z ]*$/",$name) ) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																																											 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																																											 <span aria-hidden='true'>&times;</span>
																																											 </button>
																																											 <strong>Warning!</strong> Only letters and white space allowed for the Name!
																																											 </div>";

								if(empty($email)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																						<span aria-hidden='true'>&times;</span>
																						</button>
																						<strong>Warning!</strong> You forgot to enter Email!
																						</div>";

									// check if e-mail address is well-formed
 						     if ( !empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) ) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																										 																						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																										 																						<span aria-hidden='true'>&times;</span>
																										 																						</button>
																										 																						<strong>Warning!</strong> Invalid Email Format!
																										 																						</div>";

								if(empty($comments)) $error[]= "<div class='alert alert-danger alert-dismissible' role='alert'>
																								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
																								<span aria-hidden='true'>&times;</span>
																								</button>
																								<strong>Warning!</strong> You forgot to enter Comments!
																								</div>";

	  							if(empty($error)) {

									// create the body
									$body = "Name: {$_POST['name']} \n\n Email: {$_POST['email']} \n\n Comments: {$_POST['comments']}";

									// make it no longer than 70 characters long
									$body = wordwrap($body, 70);

									// send the email
									mail('dvelasquez@mitre.org', 'New Feedback about the Vetworking System', $body, "Form: {$_POST['email']}");

									// print the message
									//echo '<p><em>Thank you for contacting us.</em></p>';
									echo "<div class='alert alert-success alert-dismissible' role='alert'>
												<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
												<span aria-hidden='true'>&times;</span>
												</button>
												<strong>Thank you!</strong> Thanks for contacting us :)
												</div>";

									// clear $_POST (so that the form's not sticky)
									$_POST = array();

								//}

								}
								else {
									//print error information
									foreach ($error as $err){
										echo $err;
									}
								}
							}
							else {
								echo "error";
							}

						} // end of main isset() IF.

					 ?>

						<h4 class="text-center">Please fill out this form to contact us!</h4>

						<!-- create the form -->
						<form name="contact_us" method="post" class="form-horizontal" onSubmit="validateForm(contact_us.comments)">

							<!-- name -->
							<div class="form-group">
	              <label for="name" class="col-sm-2 control-label">Name</label>
	              <div class="col-sm-10"> <!-- Choose the default size, it was full "10" -->
	                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value =
									<?php if(isset($_POST['name'])) echo $_POST['name'] ?>>
	              </div>
	            </div>
							<!-- /name -->

							<!-- password -->
							<div class="form-group">
	              <label for="email" class="col-sm-2 control-label">Email Address</label>
	              <div class="col-sm-10"> <!-- Choose the default size, it was full "10" -->
	                <input type="text" class="form-control" id="email" placeholder="Email" name="email" value =
									<?php if(isset($_POST['email'])) echo $_POST['email'] ?>>
	              </div>
	            </div>
							<!-- /password -->

							<!-- comments -->
							<div class="form-group">
								<label for="comments" class="col-sm-2 control-label">Comments</label>
								<div class="col-sm-10"> <!-- Choose the default size, it was full "10" -->
									<textarea class="form-control" rows="3" name="comments"><?php if(isset($_POST['comments'])) echo $_POST['comments'] ?></textarea>
								</div>
							</div>
							<!-- /comments -->

							<!-- button -->
							<div class="form-group">
	              <div class="col-sm-offset-2 col-sm-10">
	                <button type="submit" class="btn btn-primary" name="submit" value="Send">Send</button>
	              </div>
	            </div>
							<!-- /button -->

						</form>
						<!-- /form -->

        </div> <!-- /.jumbotron -->

        <div clas="col-md-12">
          <p id="footer" class="text-center">Copyright@ MITRE Business Strategist</p>
        </div>

      </div> <!-- /.row -->
    </div> <!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
