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
    var username;
 var textContent = '<div class="card"><section class="post-heading"><div class="row"><div class="col-md-11"><div class="media"><div class="media-left"><a href="VIEWPROFILE"><img class="media-object photo-profile" src="POSTUSERPHOTO" width="40" height="40" alt="..."></a></div><div class="media-body"><a href="VIEWPROFILE" class="anchor-username"><h4 class="media-heading postUser">POSTUSERID</h4></a><a href="#" class="anchor-time">POSTUSERNEIGHBOURHOOD</a></div></div></div></div></section><section class="post-body"><p id="postDescription">POSTDESCRIPTION</p></section><section class="post-footer"><hr><div class="post-footer-option"><ul class="list-unstyled"><li><a onclick="addLikes(POSTADDLIKES);" LIKESTYLE"><i class="glyphicon glyphicon-thumbs-up"></i> <span id ="POSTLIKEID" >POSTLIKES</span></a></li><li><a onclick="addDisLikes(POSTADDDISLIKES);" DISLIKESTYLE><i class="glyphicon glyphicon-thumbs-down"></i><span id ="POSTDISLIKEID" >POSTDISLIKES</span></a></li><li><a href="COMMENTSURL"><i class="glyphicon glyphicon-comment"></i> POSTCOMMENTS</a></li></ul></div></section></div>';

    var imageContent='<div class="card"><section class="post-heading"><div class="row"><div class="col-md-11"><div class="media"><div class="media-left"><a href="VIEWPROFILE"><img class="media-object photo-profile" src="POSTUSERPHOTO" width="40" height="40" alt="..."></a></div><div class="media-body"><a href="VIEWPROFILE" class="anchor-username"><h4 class="media-heading postUser">POSTUSERID</h4></a><a href="#" class="anchor-time">POSTUSERNEIGHBOURHOOD</a></div></div></div></div></section><section class="post-body"><div class="imgPost"><img src="IMGURL" height="50px" class="img-responsive imgContent"></div><div class="postDescription"><p id="postDescription" class="postDescription">POSTDESCRIPTION</p></div></section><section class="post-footer"><hr><div class="post-footer-option"><ul class="list-unstyled"><li><a onclick="addLikes(POSTADDLIKES);" LIKESTYLE"><i class="glyphicon glyphicon-thumbs-up"></i> <span id ="POSTLIKEID" >POSTLIKES</span></a></li><li><a onclick="addDisLikes(POSTADDDISLIKES);" DISLIKESTYLE><i class="glyphicon glyphicon-thumbs-down"></i><span id ="POSTDISLIKEID" >POSTDISLIKES</span></a></li><li><a href="COMMENTSURL"><i class="glyphicon glyphicon-comment"></i> POSTCOMMENTS</a></li></ul></div></section></div>';

    var audioContent='<div class="card"><section class="post-heading"><div class="row"><div class="col-md-11"><div class="media"><div class="media-left"><a href="VIEWPROFILE"><img class="media-object photo-profile" src="POSTUSERPHOTO" width="40" height="40" alt="..."></a></div><div class="media-body"><a href="VIEWPROFILE" class="anchor-username"><h4 class="media-heading postUser">POSTUSERID</h4></a><a href="#" class="anchor-time">POSTUSERNEIGHBOURHOOD</a></div></div></div></div></section><section class="post-body"><div class="audioPost"><audio src="AUDIOURL" controls></div><div class="postDescription"><p id="postDescription" class="postDescription">POSTDESCRIPTION</p></div></section><section class="post-footer"><hr><section class="post-footer"><hr><div class="post-footer-option"><ul class="list-unstyled"><li><a onclick="addLikes(POSTADDLIKES);" LIKESTYLE"><i class="glyphicon glyphicon-thumbs-up"></i> <span id ="POSTLIKEID" >POSTLIKES</span></a></li><li><a onclick="addDisLikes(POSTADDDISLIKES);" DISLIKESTYLE><i class="glyphicon glyphicon-thumbs-down"></i><span id ="POSTDISLIKEID" >POSTDISLIKES</span></a></li><li><a href="COMMENTSURL"><i class="glyphicon glyphicon-comment"></i> POSTCOMMENTS</a></li></ul></div></section></div>';

    var videoContent='<div class="card"><section class="post-heading"><div class="row"><div class="col-md-11"><div class="media"><div class="media-left"><a href="VIEWPROFILE"><img class="media-object photo-profile" src="POSTUSERPHOTO" width="40" height="40" alt="..."></a></div><div class="media-body"><a href="VIEWPROFILE" class="anchor-username"><h4 class="media-heading postUser">POSTUSERID</h4></a><a href="#" class="anchor-time">POSTUSERNEIGHBOURHOOD</a></div></div></div></div></section><section class="post-body"><div class="videoPost"><video width="400" src="VIDEOURL" controls> </video></div><div class="postDescription"><p id="postDescription" class="postDescription">POSTDESCRIPTION</p></div></section><section class="post-footer"><hr><div class="post-footer-option"><ul class="list-unstyled"><li><a onclick="addLikes(POSTADDLIKES);" LIKESTYLE"><i class="glyphicon glyphicon-thumbs-up"></i> <span id ="POSTLIKEID" >POSTLIKES</span></a></li><li><a onclick="addDisLikes(POSTADDDISLIKES);" DISLIKESTYLE><i class="glyphicon glyphicon-thumbs-down"></i><span id ="POSTDISLIKEID" >POSTDISLIKES</span></a></li><li><a href="COMMENTSURL"><i class="glyphicon glyphicon-comment"></i> POSTCOMMENTS</a></li></ul></div></section></div>';
    function getdetails(){
        $(document).ready(function() {
            console.log("Starting");

            var jsonobj = {"to_call": "get_post_data"}
            $.ajax({
              type: "POST",
              url: "home_handler.php",
              data: { home_info: JSON.stringify(jsonobj)},
              success: function(response){
                response=JSON.parse(response);
                console.log(response);

                //Split post by type
                posts =[];
                posts = response["posts"];
                posts.forEach(function(a){
                    var t;
                    if(a.file_type=="image"){
                        t=imageContent.replace("POSTUSERID",a.user_name);
                        t=t.replace("POSTUSERNEIGHBOURHOOD",a.neighbourhood);
                        t=t.replace("POSTDESCRIPTION",a.desc_text);
                        t=t.replace("POSTUSERPHOTO",a.photo);
                        t=t.replace("POSTLIKES",((a.likes)?a.likes:0));
                        t=t.replace("POSTDISLIKES",((a.dislikes)?a.dislikes:0));
                        t=t.replace("POSTCOMMENTS",((a.comments)?a.comments:0));
                        t=t.replace("IMGURL","uploads/"+a.resource_url);    
                    }else if(a.file_type=="audio"){
                        t=audioContent.replace("POSTUSERID",a.user_name);
                        t=t.replace("POSTUSERNEIGHBOURHOOD",a.neighbourhood);
                        t=t.replace("POSTDESCRIPTION",a.desc_text);
                        t=t.replace("POSTUSERPHOTO",a.photo);
                        t=t.replace("POSTLIKES",((a.likes)?a.likes:0));
                        t=t.replace("POSTDISLIKES",((a.dislikes)?a.dislikes:0));
                        t=t.replace("POSTCOMMENTS",((a.comments)?a.comments:0));
                        t=t.replace("AUDIOURL","uploads/"+a.resource_url);    
                    }else if(a.file_type=="video"){
                        t=videoContent.replace("POSTUSERID",a.user_name);
                        t=t.replace("POSTUSERNEIGHBOURHOOD",a.neighbourhood);
                        t=t.replace("POSTDESCRIPTION",a.desc_text);
                        t=t.replace("POSTUSERPHOTO",a.photo);
                        t=t.replace("POSTLIKES",((a.likes)?a.likes:0));
                        t=t.replace("POSTDISLIKES",((a.dislikes)?a.dislikes:0));
                        t=t.replace("POSTCOMMENTS",((a.comments)?a.comments:0));
                        t=t.replace("VIDEOURL","uploads/"+a.resource_url);    
                    }else{
                        t =textContent.replace("POSTUSERID",a.user_name);
                        t=t.replace("POSTUSERPHOTO",a.photo);
                        t=t.replace("POSTUSERNEIGHBOURHOOD",a.neighbourhood);
                        t=t.replace("POSTLIKES",((a.likes)?a.likes:0));
                        t=t.replace("POSTDISLIKES",((a.dislikes)?a.dislikes:0));
                        t=t.replace("POSTCOMMENTS",((a.comments)?a.comments:0));
                        t=t.replace("POSTDESCRIPTION",a.desc_text);

                    }
                    // if(a.user_reaction==1){
                    //     t=t.replace("LIKESTYLE","style='color: blue;'");
                    // }else if(a.user_reaction==2){
                    //     t=t.replace("DISLIKESTYLE","style='color: blue;'");
                    // }
                    t=t.replace("VIEWPROFILE","viewProfile.php?user_id="+a.user_id);
                    t=t.replace("VIEWPROFILE","viewProfile.php?user_id="+a.user_id);
                    t=t.replace("COMMENTSURL","comments.php?post_id="+a.post_id);
                    t=t.replace("POSTLIKEID","postLike"+a.post_id);
                    t=t.replace("POSTDISLIKEID","postDislike"+a.post_id);
                    t=t.replace("POSTADDLIKES",a.post_id);
                    t=t.replace("POSTADDDISLIKES",a.post_id);

                    $('#postList').append('<li id="'+a.post_id+'">'+t+'</li>');
                });

              }
            });
        }); 
    }
    getdetails();

    function addLikes(postId){
         var jsonobj = {"to_call": "put_post_reaction_data",
                        "post_id": postId,
                        "reaction": "1"}
            $.ajax({
              type: "POST",
              url: "home_handler.php",
              data: { home_info: JSON.stringify(jsonobj)},
              success: function(response){
                response=JSON.parse(response);
                $('#postLike'+postId).text((response.likes)?response.likes:0);
              },
              fail: function(error) {
                alert("error "+error);
                location.reload();
              }
        });
    }
    function addDisLikes(postId){
        $("#comments").val("");
         var jsonobj = {"to_call": "put_post_reaction_data",
                        "post_id": postId,
                        "reaction": "2"}
            $.ajax({
              type: "POST",
              url: "home_handler.php",
              data: { home_info: JSON.stringify(jsonobj)},
              success: function(response){
                response=JSON.parse(response);
                $('#postDislike'+postId).text((response.dislikes)?response.dislikes:0);
              },
              fail: function(error) {
                alert("error "+error);
                location.reload();
              }
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
                        <li class="active"><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Home</span></a></li>
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
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                            </nav>
                            <div class="search hidden-xs hidden-sm">
                                <h2>HOME</h2>
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

                    <!-- ADD POST -->
                    <div class="row">
                        <div class="postCard">
                            <div class="well well-sm well-social-post">
                            <div class="tabbable-panel">
                        <div class="tabbable-line tabs-below">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="text">
                                    <form action="upload.php" method="post" enctype="multipart/form-data">
                                    <div>

                                    <textarea class="form-control" name="desc" id="desc" placeholder="What's in your mind?"></textarea></div>
                                    <div class='pull-right postCardSubmit'>
                                        <input type="text" style="display:none;" name="type" value="text" id="type">
                                    <input type="submit" class='btn btn-primary .btn-large' value="POST" name="submit" style="margin-top:10px;"></div>
                                </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="audio">
                                    <form action="upload.php" method="post" enctype="multipart/form-data">
                                        <textarea class="form-control" name="desc" id="desc" placeholder="What's in your mind?"></textarea>
                                        <br>
                                        Select Audio File to upload:
                                        <input type="file" name="fileToUpload" id="fileToUpload" required="required">
                                        <input type="text" style="display:none;" name="type" value="audio" id="type">
                                         <div class='pull-right postCardSubmit'>
                                    <input type="submit" class='btn btn-primary .btn-large' value="POST" name="submit"></div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="video">
                                    <form action="upload.php" method="post" enctype="multipart/form-data">
                                        <textarea class="form-control" name="desc" id="desc" placeholder="What's in your mind?"></textarea>
                                        <br>
                                        Select video to upload:
                                        <input type="file" name="fileToUpload" id="fileToUpload" required="required">
                                        <input type="text" style="display:none;" name="type" value="video" id="type">
                                        <div class='pull-right postCardSubmit'>
                                    <input type="submit" class='btn btn-primary .btn-large' value="POST" name="submit"></div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="image">
                                    <form action="upload.php" method="post" enctype="multipart/form-data">
                                        <textarea class="form-control" name="desc" id="desc" placeholder="What's in your mind?"></textarea>
                                        <br>
                                        Select image to upload:
                                        <input type="file" name="fileToUpload" id="fileToUpload" required="required">
                                        <input type="text" style="display:none;" name="type" value="image" id="type">
                                         <div class='pull-right postCardSubmit'>
                                    <input type="submit" class='btn btn-primary .btn-large' value="POST" name="submit"></div>
                                    </form>
                                </div>
                                <div class="postCardElements">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#text" aria-controls="text" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span></a></li>
                                        <li role="presentation"><a href="#audio" aria-controls="audio" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-volume-up"></span></a></li>
                                        <li role="presentation"><a href="#video" aria-controls="video" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-film"></span></a></li>
                                        <li role="presentation"><a href="#image" aria-controls="image" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-camera"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                            </div>
                        </div>
                    </div>




                    <!-- DISPLAY POST -->
                    <ul class="postList" id="postList">
                    </ul>

                </div>
            </div>
        </div>
    </div>
</body>

</html>