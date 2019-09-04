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
    <script type="text/javascript">
    //Function when users enters code
    function codenetered() {
        console.log(document.getElementById("code").value);
    }
    </script>
</head>

<body>
    <div class="container">
        <div class="row ">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel codeVerfiy">
                    <div class="panel-heading rucheader">
                        <div class="banner">
                            <div class="rucHeaderContent">
                                RUC!
                            </div>
                        </div>
                        <div class="banner-line">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <h2 class="signUp"> 
                                Sign Up
                            </h2>
                        </div>
                        <div>
                            <h3><label>
                                Please enter the verification code:    </label>
                            </h3>
                        </div>
                        <div class="codeBox">
                            <!-- <input id="code" onblur="codenetered()" type="text" name="code"  tabindex="1"  placeholder="000-admin-000" value=""> -->
                            <form class="form-inline" action="verifycode.php" method="POST">
                              <div class="form-group mx-sm-3 mb-2">
                                <input id="code" onblur="codenetered()" type="text" name="code" class="form-control" tabindex="1"  placeholder="123456789" value=""> 
                              </div>
                              <button type="submit" class="btn btn-primary mb-2">Submit</button>
                            </form>
                        </div><div>
                            <h3>
                                No code? Click <span><a href="getcode.html" class="signUp">here.</a></span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>