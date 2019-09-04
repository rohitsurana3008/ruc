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
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/home.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
        <script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="offcanvas"]').click(function() {
            $("#navigation").toggleClass("hidden-xs");
        });
    });
     $(document).ready(function() {
        var user_id = <?php echo $_REQUEST["user_id"]; ?>;
        console.log("Starting");
        $.ajax({
          url: 'view_handler.php',
                data: 'user_id='+user_id,
                dataType: "json",
                type: 'POST',
          success: function(response){
            console.log(response);
            myData = response;
            myBadges = response.badges;
            length = myBadges.length;
            console.log(length);
            $('#profile_img').attr('src', myData.user_img);
            $('#profile_name').html(myData.user_name);
            $('#profile_city').html(myData.neighbourhood);
            $('#profile_lived_since').html(myData.lived_since);
            $('#profile_about').html(myData.about_me);
            $('#profile_sports').html(myData.sports_activities);
            $('#profile_hobbies').html(myData.hobbies);
            $('#profile_favourite_places').html(myData.favourite_places);
            document.getElementById("profile_points").innerHTML=myData.points
            for(var i = 0; i < length; i++)
            {
                var img = document.createElement("img");
                img.setAttribute('class', 'img-rounded img-responsive');
                img.setAttribute('src', myBadges[i]);
                img.setAttribute('alt', 'Badges');
                var div = document.createElement("div");
                div.setAttribute('class', 'cell1');
                div.appendChild(img);
                document.getElementById("badges").appendChild(div);
            }
            if(length == 0)
            {
                $('#badges').html("No Badges");
            }
          }
        });
    }); 
    

    </script>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="logo">
                    <a hef="home.html"><img src="uploads/RUC_logo.jpg" style="max-width:auto;max-height:auto;width:80px;"></a>
                </div>
                <div class="navi">
                    <ul>
						<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Home</span></a></li>
                        <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Profile</span></a></li>
                        <li><a href="cmhelp.php"><i class="fa fa-globe"></i><span class="hidden-xs hidden-sm">Community Help</span></a></li>
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
                                    </button>
                                </div>
                            </nav>
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
                    
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-12 gutter">
                            <div class="card">
                                <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <img src="" alt="Profile Pic" id="profile_img" class="img-rounded img-responsive"  />
                                </div>

                                <div class="col-sm-8 col-xs-12">
                                    <h2 id="profile_name" style="text-transform:uppercase"></h2>
                                    <hr style="margin-bottom:10px;margin-top:10px;"/>
                                    <p class="profile_card"><i class="glyphicon glyphicon-map-marker">
                                    </i><span id="profile_city"></span></p>
                                    <p class="profile_card">
                                        <i class="glyphicon glyphicon-calendar"></i>I've lived here for <span id="profile_lived_since"></span>
                                        </p>
                                        <p class="profile_card">
                                        <i class="glyphicon glyphicon-gift"></i>Points: <span id="profile_points"></span>
                                    </p>
                                </div>
                            </div>
                            
                                
                                    
                            </div>


                            

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel1"></h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p id="result"> </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel2"></h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid" id="container_div">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <h2>Badges</h2>
                                <div class="badges" id="badges">
                                    

                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12 gutter">
                            <div class="card">
                                <h2>About Me</h2>
                                <p id="profile_about"></p>
                            </div>
                            <div class="card">
                                <h2>My Favorite Sports/Activities</h2>
                                <p id="profile_sports"></p>
                            </div>
                            <div class="card">
                                <h2>My hobbies</h2>
                                <p id="profile_hobbies"></p>
                            </div>
                            <div class="card">
                                <h2>My Favorite Places</h2>
                                <p id="profile_favourite_places"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>