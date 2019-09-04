<?php 
 session_start();
 $user_id = $_SESSION['user_id'];
 if($user_id == null || $user_id = "")
 {
    header('location: index.php');
 }
 ?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/home.css" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="offcanvas"]').click(function() {
            $("#navigation").toggleClass("hidden-xs");
        });
    });
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
        function display(value) {
            if(value){
                if(value=="success"){
                alert("Your help has been accepted and points have been updated");
                window.location.href="/ruc/cmhelp.php";
            }else if(value=="Error Uploading File"){
                alert("Sorry. ErrorUploadingFile! Please note only photos are accepted");
            }else if(value=="fileformatnotsupported"){
                alert("Sorry. Error Uploading File! Please note only photos are accepted");
            }else{
                alert("Sorry. Server Down Please try after sometime");
            }    
        }
            
        }
        display(getParameterByName("error"));
    </script>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="logo">
                    <a href="home.html"><img src="uploads/RUC_logo.jpg" style="max-width:auto;max-height:auto;width:80px;"></a>
                </div>
                <div class="navi">
                    <ul>
                        <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Home</span></a></li>
                        <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Profile</span></a></li>
                        <li class="active"><a href="cmhelp.php"><i class="fa fa-globe"></i><span class="hidden-xs hidden-sm">Community Help</span></a></li>
                        <li><a href="challenge.php"><i class="fa fa-trophy" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Challenges</span></a></li>
                        <li><a href="LeaderBoard.php"><i class="fa fa-users" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Leaderboard</span></a></li>
                        <li><a href="redeem.php"><i class="fa fa-money" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Redeem</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                <!--<button type="button" class="slide-toggle">Slide Toggle</button> -->
                <div class="row">
                    <header>
                        <div class="col-md-7">
                            <nav class="navbar-default pull-left">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                            </nav>
                            <div class="search hidden-xs hidden-sm">
                                <h2>Community Help</h2>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="header-rightside">
                                <ul class="list-inline header-top pull-right">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['user_name'];?>
                                            <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="navbar-content">
                                                    <span><?php echo $_SESSION['user_name'];?></span>
                                                    <p class="text-muted small">
                                                        <?php echo $_SESSION['user_email'];?>
                                                    </p>
                                                    <div class="divider">
                                                    </div>
                                                    <a href="logout.php" class="view btn-sm active">Logout</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </header>
                </div>
                 <div class="user-dashboard">
                    <div class="card" id="addComments">
                        <h4>I have accomplished the following tasks in the community</h4>
                        <form action="communityHelp.php" method="post" enctype="multipart/form-data">
                            <textarea class="form-control" name="desc" id="desc" placeholder="Description of the task completed" required></textarea>
                            <br/> 
                            <label><h4>Time Taken to complete the task</h4></label>
                            <div>
                                <select name="time_taken" required>
                                    <option value="30">30 Minutes</option>
                                    <option value="60">60 Minutes</option>
                                    <option value="90">90 Minutes</option>
                                    <option value="100">More than 90 Minutes</option>
                                </select>
                            </div>
                            <br/>
                            <h4>Select image to upload:</h4>
                            <input type="file" name="fileToUpload" id="fileToUpload" required="required">
                            <input type="text" style="display:none;" name="type" value="image" id="type">
                            <div class='pull-right postCardSubmit'>
                                <input type="submit" class='btn btn-primary .btn-large' value="POST" name="submit">
                            </div>
                        </form>
                        <h5 class="conditonsApply">*Please note that the validity of the post is verfied by the moderator</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>