<?php
/**
 * Created by IntelliJ IDEA.
 * User: omkar
 * Date: 4/6/2018
 * Time: 11:21 PM
 */

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
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="assets/css/home.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <script type="text/javascript">


            $(document).ready(function() {
                console.log("Starting");

                var i = 1;

                var jsonobj = {"to_call": "get_post_data"}
                $.ajax({
                    type: "POST",
                    url: "LeaderBoardHandler.php",
                    data: {profile_info: JSON.stringify(jsonobj)},
                    success: function(response){
                        response=JSON.parse(response);
                        console.log(response);


                        if(response.code == 200)
                        {

                            $('#container_div').empty();
                            //Split post by type
                            data_ =[];
                            data_ = response["data"];
                            data_.forEach(function(a){

                                var photo = a.photo;
                                var user_name = a.user_name;
                                var points = a.points;

                                var data1="<div class=\"card\" style=\"display: block; height: 20%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);\n" +
                                    "            margin-top: 10px\">\n" +
                                    "                <div class='row'>\n" +
                                    "                    <div class='col-md-1 col-xs-3' style=\"padding: 20px\">\n" +
                                    "                        <b>"+i+"</b>\n" +
                                    "                    </div>\n" +
                                    "                     <div class='col-md-1 col-xs-3' style=\"padding: 10px\" >\n" +
                                    "                        <img src='"+photo+"' height=\"50\" width=\"50\" />\n" +
                                    "                     </div>\n" +
                                    "                    <div class='col-md-3 col-xs-4' style=\"padding: 20px\">\n" +
                                    "                        <b>"+user_name+"</b>\n" +
                                    "                    </div>\n" +
                                    "                <div class='col-md-1 col-xs-1' style=\"padding: 20px\">\n<b style='color:#F57C00'>" +
                                    "                "+points+"</b>\n" +
                                    "                </div>\n" +
                                    "            </div>\n" +
                                    "            </div>"

                                $('#leaderboard_list').append(data1);

                                i++;

                            });
                        }
                        else
                        {
                            alert("Service temporarily down, Please try again in sometime");
                        }


                    },
                });
            });


    </script>
</head>
<body class="home">
<div class="container-fluid display-table">
    <div class="row display-table-row">
        <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
            <div class="logo">
                <a href="home.php"><img src="uploads/RUC_logo.jpg" style="max-width:auto;max-height:auto;width:80px;"></a>
            </div>
            <div class="navi">
                <ul>
                    <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Home</span></a></li>
                    <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Profile</span></a></li>
                    <li><a href="cmhelp.php"><i class="fa fa-globe"></i><span class="hidden-xs hidden-sm">Community Help</span></a></li>
                    <li><a href="challenge.php"><i class="fa fa-trophy" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Challenges</span></a></li>
                    <li class="active"><a href="LeaderBoard.php"><i class="fa fa-trophy" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Leaderboard</span></a></li>
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
                            <h2><b>Leaderboard</b></h2>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="header-rightside">
                            <ul class="list-inline header-top pull-right">
                                <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                                <li>
                                    <a href="#" class="icon-info">
                                        <i class="fa fa-bell" aria-hidden="true"></i>
                                        <span class="label label-primary">3</span>
                                    </a>
                                </li>
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

            <div id = "leaderboard_list">

            <div class="card" style="display: block; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            margin-top: 10px">
                <div class='row'>
                    <div class='col-md-1 col-xs-4' style="padding-left: 20px">
                        <b style="color:#F57C00">Rank</b>
                    </div>
                     <div class="col-md-1 col-xs-4"  style="padding-left: 20px">

                     </div>
                    <div class='col-md-3 col-xs-4' style="padding-left:20px">
                        <b style="color:#F57C00">Name</b>
                    </div>
                <div class='col-md-1 col-xs-4' style="padding-left:20px">
                    <b style='color:#F57C00'>Points</b>
                </div>
            </div>
            </div>
                <!--
                    <div class="card" style="display: block; height: 20%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                margin-top: 10px">
                        <div class='row'>
                            <div class='col-md-1 col-xs-4' style="padding: 20px">
                                <b>1</b>
                            </div>
                            <div class="col-md-1 col-xs-4"  style="padding-left: 20px">
                                <img src="uploads/152200192669100.jpg" height="50" width="50" />
                            </div>
                            <div class='col-md-3 col-xs-4' style="padding: 20px">
                                <b>Omkar Sawant</b>
                            </div>
                            <div class='col-md-1 col-xs-4' style="padding: 20px">
                                96
                            </div>
                        </div>
                    </div>

                    <div class="card" style="display: block; height: 20%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                margin-top: 10px">
                        <div class='row'>
                            <div class='col-md-1 col-xs-4' style="padding: 20px">
                                <b>1</b>
                            </div>
                            <div class="col-md-3 col-xs-4"  style="padding-left: 20px">
                                <img src="uploads/152200192669100.jpg" height="50" width="50" />
                            </div>
                            <div class='col-md-3 col-xs-4' style="padding: 20px">
                                <b>Omkar Sawant</b>
                            </div>
                            <div class='col-md-3 col-xs-4' style="padding: 20px">
                                96
                            </div>
                        </div>
                    </div>
    -->
            </div>
            </div>

    </div>
</div>


    </body>
</html>