<?php
define('DOT','.');
require_once(DOT ."/bootstrap.php");
?>

<!DOCTYPE html>

<html>

<head>

    <title>MailDox : Login</title>

    <meta charset="utf-8">

    <base href="<?= $core->domain ?>" />

    <meta content="ie=edge" http-equiv="x-ua-compatible">

    <meta content="width=device-width, initial-scale=1" name="viewport">

    <link href="favicon.png" rel="shortcut icon">

    <link href="apple-touch-icon.png" rel="apple-touch-icon">

    <link href="bower_components\select2\dist\css\select2.min.css" rel="stylesheet">

    <link href="//fast.fonts.net/cssapi/175a63a1-3f26-476a-ab32-4e21cbdb8be2.css" rel="stylesheet">

    <link href="bower_components\bootstrap-daterangepicker\daterangepicker.css" rel="stylesheet">

    <link href="bower_components\dropzone\dist\dropzone.css" rel="stylesheet">

    <link href="bower_components\datatables\media\css\jquery.dataTables.min.css" rel="stylesheet">

    <link href="bower_components\datatables\media\css\dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="bower_components\fullcalendar\dist\fullcalendar.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <link href="css\main.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</head>



<body class="auth-wrapper">

    <div class="all-wrapper with-pattern">

        <div class="auth-box-w">
			
            <p>&nbsp;</p>
       		<h4 class="auth-header">Login Form</h4>

            <form action="execute.php" method="post">

            	<input type="hidden" name="cmd" value="login" />

 

				<?php include_once(DOT ."/err.phtml"); ?>

               <div class="form-group">

                    <label for="">Username</label>

                    <input class="form-control" name="email" required placeholder="Enter your email" type="email">

                    <div class="pre-icon os-icon os-icon-user-male-circle"></div>

                </div>

                <div class="form-group">

                    <label for="">Password</label>

                    <input class="form-control" name="password" required placeholder="Enter your password" type="password">

                    <div class="pre-icon os-icon os-icon-fingerprint"></div>

                </div>

                <div class="buttons-w">

                    <button class="btn btn-primary col-12">Log me in</button>

                </div>

                

                <div style="margin:15px;">

                <center><br/><a href="./">Account Home</a> </center>

                </div>

                

            </form>

        </div>

    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>    

    <script src="js/ajax.js"></script>

</body>



</html>