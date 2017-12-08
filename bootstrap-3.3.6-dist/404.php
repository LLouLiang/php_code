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

		<!-- redirect the page after seconds -->
		<meta http-equiv="refresh" content="6; url=http://vetworking.x10host.com/bootstrap-3.3.6-dist/index.php">

		<title>Page Not Found!!</title>

    <!-- Bootstrap -->
    <link href="http://vetworking.x10host.com/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://vetworking.x10host.com/bootstrap-3.3.6-dist/css/vs-style.css" rel="stylesheet">

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

        <div class="jumbotron">
					<div class="alert alert-danger" role="alert"><strong>Page Not Found! </strong>Sorry, we cannot find that page</div>
					<div class="form-group has-error">
						<h4 id="helpBlock2" class="help-block">You'll be redirected to the Home page .. Please wait</h4>
					</div>
					<a href = "http://vetworking.x10host.com/bootstrap-3.3.6-dist/index.php">Or click here to go to the Home Page directly.</a>
        </div> <!-- /.jumbotron -->

        <div clas="col-md-12">
          <p id="footer" class="text-center">Copyright@ MITRE Business Strategist</p>
        </div>

      </div> <!-- /.row -->
    </div> <!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src=""></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://vetworking.x10host.com/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
  </body>
</html>
