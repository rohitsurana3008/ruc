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
            
        var challengeContent ='<div class="post-footer-comment-wrapper"><div class="card"><div class="media"><div class="media-left"><a href="#"><img class="media-object photo-profile" src="CHALLENGERPHOTO" width="32" height="32" alt="..."></a></div><div class="media-body"><h2 class="media-heading">CHALLENGERNAME</h2></div><div <div class="post-body"><label>Challenge Description</label><p id="postDescription">CHALLENGETEXT</p><label>Challenge Points</label><p id="postDescription">CHALLENGEPOINTS &nbsp;Point(s)</p><label>Time to Complete Challange</label><p id="postDescription">CHALLENGEDURATION</p></div></div></div></div>';

    function getdetails(){
        $(document).ready(function() {
            console.log("Starting");
            var jsonobj = {"to_call": "get_my_active_challenges_data"}
            $.ajax({
              type: "POST",
              url: "challenges_handler.php",
              data: { challenge_info: JSON.stringify(jsonobj)},
              success: function(response){
                response=JSON.parse(response);
                console.log(response);
                var challenges =[];
                challenges=response["challenges"];
                 challenges.forEach(function(response){
                    var t;
                    t =challengeContent.replace("CHALLENGERNAME",response.challenge_by);
                    t=t.replace("CHALLENGERPHOTO",response.photo);
                    t=t.replace("CHALLENGEDURATION",response.end_at)
                    t=t.replace("CHALLENGEPOINTS",response.points);
                    t=t.replace("CHALLENGETEXT",response.desc_text);
                    t=t.replace("CHALLENGESAVEID",response.challenge_id);
                    $('#challengeList').append('<li id="'+response.challenge_id+'">'+t+'</li>');
                });



                }
            });
        }); 
    }
    getdetails();
    function createChallenge(){
        var challenge_info={
                "desc_text":$("#challenge_desc").val(),
                "points":$("#challenge_points").val(),
                "duration":$("#challenge_duration").val()
            }
        $.ajax({
          type: "POST",
          url: "createChallenges.php",
          data: { challenge_info: JSON.stringify(challenge_info)},
          success: function(response){
            $('#addChallenge').modal('hide');
            console.log(response);
            response=JSON.parse(response);
            alert(response.result);
            location.reload();
          },
        });
    }
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
                        <li ><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Home</span></a></li>
                        <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Profile</span></a></li>
                        <li><a href="cmhelp.php"><i class="fa fa-globe"></i><span class="hidden-xs hidden-sm">Community Help</span></a></li>
                        <li class="active"><a href="challenge.php"><i class="fa fa-trophy" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Challenges</span></a></li>
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
                                <h2>Challenges</h2>
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
                     <div class="challengenavbar">
                    <ul>
                        <li><a href="challenge.php">Open Challenges</a></li>
                        <li class="activechallenge push"><a href="activechallenge.php">My Accepted Challenges</a></li>
                        <li class="push"><a href="approvechallenge.php">My Posted Challanges</a></li>
                         <li class="pull-right"> <button type="button" class="btn btn-primary" style="background: #F57C00" data-toggle="modal" data-target="#addChallenge">Add a challenge</button></li>
                    </ul>
                </div><!-- /.nav-collapse -->
                
                <ul class="challengeList" id="challengeList">
                    </ul>
                </div>
            </div>
        </div>
    </div>

     <!-- MODAL CONTNET -->
        <div class="modal fade" id="addChallenge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div style="display: flex" class="modal-header">
                        <h5 style="width: 98%" class="modal-title" id="exampleModalLabel"><b>Create Challenge</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Challenge Desc</label>
                                <textarea class="form-control" name="challenge_desc" id="challenge_desc" placeholder="Description of the task" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="recipient-email" class="col-form-label">Points</label>
                                <input type="number" class="form-control" id="challenge_points">
                            </div>
                            <div class="form-group">
                                <label for="recipient-email" class="col-form-label">Duration</label>
                                <select id="challenge_duration" class="form-control">
                                    <option value="1">1 Day</option>
                                    <option value="2">2 Days</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="createChallenge();">Create Challenge</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- MODAL ENDS -->
</body>

</html>