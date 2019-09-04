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
    var textContent = '<div class="card"><section class="post-heading"><div class="row"><div class="col-md-11"><div class="media"><div class="media-left"><a href="#"><img class="media-object photo-profile" src="POSTUSERPHOTO" width="40" height="40" alt="..."></a></div><div class="media-body"><a href="#" class="anchor-username"><h4 class="media-heading postUser">POSTUSERID</h4></a><a href="#" class="anchor-time">POSTUSERNEIGHBOURHOOD</a></div></div></div></div></section><section class="post-body"><p id="postDescription">POSTDESCRIPTION</p></section><section class="post-footer"><hr><div class="post-footer-option"><ul class="list-unstyled"><li><a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> POSTLIKES</a></li><li><a href="#"><i class="glyphicon glyphicon-thumbs-down"></i> POSTDISLIKES</a></li><li><a href="COMMENTSURL"><i class="glyphicon glyphicon-comment"></i> POSTCOMMENTS</a></li></ul></div></section></div>';
    var imageContent='<div class="card"><section class="post-heading"><div class="row"><div class="col-md-11"><div class="media"><div class="media-left"><a href="#"><img class="media-object photo-profile" src="POSTUSERPHOTO" width="40" height="40" alt="..."></a></div><div class="media-body"><a href="#" class="anchor-username"><h4 class="media-heading postUser">POSTUSERID</h4></a><a href="#" class="anchor-time">POSTUSERNEIGHBOURHOOD</a></div></div></div></div></section><section class="post-body"><div class="imgPost"><img src="IMGURL" height="50px" class="img-responsive imgContent"></div><div class="postDescription"><p id="postDescription" class="postDescription">POSTDESCRIPTION</p></div></section><section class="post-footer"><hr><div class="post-footer-option"><ul class="list-unstyled"><li><a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> POSTLIKES</a></li><li><a href="#"><i class="glyphicon glyphicon-thumbs-down"></i> POSTDISLIKES</a></li><li><a href="COMMENTSURL"><i class="glyphicon glyphicon-comment"></i> POSTCOMMENTS</a></li></ul></div></section></div>';
    var audioContent='<div class="card"><section class="post-heading"><div class="row"><div class="col-md-11"><div class="media"><div class="media-left"><a href="#"><img class="media-object photo-profile" src="POSTUSERPHOTO" width="40" height="40" alt="..."></a></div><div class="media-body"><a href="#" class="anchor-username"><h4 class="media-heading postUser">POSTUSERID</h4></a><a href="#" class="anchor-time">POSTUSERNEIGHBOURHOOD</a></div></div></div></div></section><section class="post-body"><div class="audioPost"><audio src="AUDIOURL" controls></div><div class="postDescription"><p id="postDescription" class="postDescription">POSTDESCRIPTION</p></div></section><section class="post-footer"><hr><div class="post-footer-option"><ul class="list-unstyled"><li><a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> POSTLIKES</a></li><li><a href="#"><i class="glyphicon glyphicon-thumbs-down"></i> POSTDISLIKES</a></li><li><a href="COMMENTSURL"><i class="glyphicon glyphicon-comment"></i> POSTCOMMENTS</a></li></ul></div></section></div>';
    var videoContent='<div class="card"><section class="post-heading"><div class="row"><div class="col-md-11"><div class="media"><div class="media-left"><a href="#"><img class="media-object photo-profile" src="POSTUSERPHOTO" width="40" height="40" alt="..."></a></div><div class="media-body"><a href="#" class="anchor-username"><h4 class="media-heading postUser">POSTUSERID</h4></a><a href="#" class="anchor-time">POSTUSERNEIGHBOURHOOD</a></div></div></div></div></section><section class="post-body"><div class="videoPost"><video width="400" src="VIDEOURL" controls> </video></div><div class="postDescription"><p id="postDescription" class="postDescription">POSTDESCRIPTION</p></div></section><section class="post-footer"><hr><div class="post-footer-option"><ul class="list-unstyled"><li><a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> POSTLIKES</a></li><li><a href="#"><i class="glyphicon glyphicon-thumbs-down"></i> POSTDISLIKES</a></li><li><a href="COMMENTSURL"><i class="glyphicon glyphicon-comment"></i> POSTCOMMENTS</a></li></ul></div></section></div>';
var CommentsContent ='<div class="post-footer-comment-wrapper"><div class="commentsCard"><div class="media"><div class="media-left"><a href="#"><img class="media-object photo-profile" src="COMMENTUSERPHOTO" width="32" height="32" alt="..."></a></div><div class="media-body"><h4 class="media-heading">COMMENTSUSER</h4></div><div class="post-body"><p id="postDescription">COMMENTSTEXT</p></div></div></div></div>'

    function getdetails(postID){
        $(document).ready(function() {
            console.log("Starting");

            var jsonobj = {"to_call": "get_post_comment_data","post_id": postID}
            $.ajax({
              type: "POST",
              url: "home_handler.php",
              data: { home_info: JSON.stringify(jsonobj)},
              success: function(response){
                response=JSON.parse(response);
                console.log(response);
                var a = response;
                var t;
                if(a.post_id){
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
                    t=t.replace("COMMENTSURL","comments.php?post_id="+a.post_id);
                    $('#commentsPost').append(t);

                    //Split post by type
                    posts =[];
                    posts = response["comments_data"];
                    posts.forEach(function(comment){
                        var t;
                        t = CommentsContent.replace("COMMENTUSERPHOTO",comment.comment_user_photo);
                        t = t.replace("COMMENTSUSER",comment.comment_user_name);
                        t = t.replace("COMMENTSTEXT",comment.comment_desc);

                        $('#commentsList').append('<li">'+t+'</li>');

                    });
                    $("#addComments").show();
                    $("#noPost").hide();
                }else{
                    $("#addComments").hide();
                    $("#addComments").show();
                }
                

              }
            });
        }); 
    }
    function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
    getdetails(getParameterByName("post_id"));

    function saveDetails(){
        var postID=getParameterByName("post_id",);
        commentConent = $("#comments").val();
        $("#comments").val("");
         var jsonobj = {"to_call": "put_post_comment_data",
                        "post_id": postID,
                        "comment": commentConent}
            $.ajax({
              type: "POST",
              url: "home_handler.php",
              data: { home_info: JSON.stringify(jsonobj)},
              success: function(response){
                location.reload();
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
                    <a hef="home.html"><h2>RUC</h2></a>
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
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                            </nav>
                            <div class="search hidden-xs hidden-sm">
                                <h2>Comments</h2>
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

                    <div id="commentsPost">
                    <!-- DISPLAY POST -->
                    </div>
                    <div class="card" id="addComments">
                                <h2>Add Comments</h2>
                                <textarea id="comments" class="form-control" rows="2" cols="50"></textarea>
                                 <button id="saveDetails" type="button" class="pull-right btn btn-primary commentsBTn" onclick="saveDetails();">Save</button>
                            </div>
                     <div class="card" id="noPost">
                                <h4>NoPost Found</h4>
            
                            </div>
                    <ul class="commentsList" id="commentsList">
                    </ul>

                </div>
            </div>
        </div>
    </div>
</body>

</html>