<?php
require 'php/google_signup.php';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>RUC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
     <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
   
    <!-- The stylesheets -->
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" />
    <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

</head>

<body>
    <div class="container">
        <div class="row ">
            <div class="col-md-6 col-md-offset-3 coverdiv">
                <div class="main">
                </div>
                <div class="googleButton">
                    <a href="<?php echo $client->createAuthUrl()?>" class="googleLoginButton">Sign in with Google</a>
                </div>
            </div>
        </div>
    </div>
        
</body>

</html>