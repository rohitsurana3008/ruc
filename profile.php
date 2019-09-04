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

    function getdetails(){
    $(document).ready(function() {
        console.log("Starting");
        var jsonobj = {"to_call": "get_data"};
        $.ajax({
          type: "POST",
          url: "profile_handler.php",
          data: { profile_info: JSON.stringify(jsonobj)},
          success: function(response){
            response=JSON.parse(response);
            console.log(response);
            $("#about").val(response.about_me);
            $("#sports").val(response.sports_activities);
            $("#hobbies").val(response.hobbies);
            $("#places").val(response.favourite_places);
            $('#lived_since').val(response.lived_since);
            $('#neighbourhood').val(response.neighbourhood);
            document.getElementById("points").innerHTML=response.points
            myBadges = response.badges;
            for(var i = 0; i < response.badges.length; i++)
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
            if(response.badges.length == 0)
            {
                $('#badges').html("No Badges");
            }
          }
        });
    }); 
    }
    getdetails();
    $(document).ready(function() {
        $('[data-toggle="offcanvas"]').click(function() {
            $("#navigation").toggleClass("hidden-xs");
        });
    });
    function textarea_height(TextArea, MaxHeight) {
        textarea = TextArea;
        textareaRows = textarea.value.split("\n");
        if (textareaRows[0] != "undefined" && textareaRows.length < MaxHeight) counter = textareaRows.length;
        else if (textareaRows.length >= MaxHeight) counter = MaxHeight;
        else counter = 1;
        textarea.rows = counter;
    }
    function editDetails(){
        $('textarea').attr('readonly',false);
        $('textarea').addClass('input-disabled');
        $('#lived_since').attr('readonly',false);
        $('#neighbourhood').attr('readonly',false);
        $('#cancelDetails').show();
        $('#saveDetails').show();
        $('#editDetails').hide();
    }

    function cancelEditDetails(){

        getdetails();
        $('textarea').attr('readonly',true);
        $('#lived_since').attr('readonly',true);
        $('#neighbourhood').attr('readonly',true);
        $('#cancelDetails').hide();
        $('#saveDetails').hide();
        $('#editDetails').show();

    }
    function saveDetails(){
    $('textarea').attr('readonly',true);
    $('textarea').addClass('input-disabled');
    $('#lived_since').attr('readonly',true);
    $('#neighbourhood').attr('readonly',true);
        $('#cancelDetails').hide();
    $('#saveDetails').hide();
    $('#editDetails').show();
        console.log("Starting to save");
        $("#sports").val();
        $("#hobbies").val();
        $("#places").val();
        var profile_info={
                "to_call":"update_data",
                "about_me":$("#about").val(),
                "sports_activities":$("#sports").val(),
                "hobbies":$("#hobbies").val(),
                "favourite_places": $("#places").val(),
                "neighbourhood":$('#neighbourhood').val(),
                "lived_since": $('#lived_since').val(),
            }
        $.ajax({
          type: "POST",
          url: "profile_handler.php",
          data: { profile_info: JSON.stringify(profile_info)},
          success: function(response){
            console.log(response);
            response=JSON.parse(response);
            alert(response.result);
          },
        });
    }
    function generateCode(){
        console.log("Starting to save");
        console.log($("#recipient-name").val());
        console.log($("#recipient-email").val());

        var profile_info={
            "to_call":"generate_code",
            "email_id":$("#recipient-email").val()
        }

        $.ajax({
            type: "POST",
            url: "profile_handler.php",
            data: { profile_info: JSON.stringify(profile_info)},
            success: function(response){
                response=JSON.parse(response);
                console.log(response);

                $('#exampleModal').modal('hide')

                if(response.result_code == 100)
                {
                    $('#exampleModalLabel1').text("Woohoo.. Code Successfully Generated")
                    $('#result').html("<h4>The verification code for "+$("#recipient-name").val()+" is </h4><h2><b>"+response.generated_code+"</b></h2>");
                }
                else if(response.result_code == 201)
                {
                    $('#exampleModalLabel1').text("Oops...")
                    $("#result").html("<h4>User is already present in the system</h4>");
                }
                else if(response.result_code == 202)
                {
                    $('#exampleModalLabel1').text("Oops...")
                    $("#result").html("<h4>The code for the user already exists</h4>");
                }
                else
                {
                    $('#exampleModalLabel1').text("Oops...")
                    $("#result").html("<h4>Service temporarily down. Please try again in sometime.</h4>")
                }


                $('#exampleModal1').modal('show')
                //console.log(response);

            },
        });


    }

    function getVerificationCodes() {

        $('#exampleModalLabel2').text("Generated codes")
        //$('#exampleModal2').modal('show')

        var jsonobj = {"to_call": "get_generated_codes"}
        $.ajax({
            type: "POST",
            url: "profile_handler.php",
            data: {profile_info: JSON.stringify(jsonobj)},
            success: function (response) {
                response = JSON.parse(response);
                console.log(response);

                $('#container_div').empty();

                data = "<div class='row'><div class='col-md-6 col-sm-3'>Emails:"+
                   " </div><div class='col-md-6 col-sm-3'>Codes</div></div>";
                $('#container_div').append(data);


                if(response.result_code == 100)
                {
                    for (var counter in response.generated_codes) {
                        console.log(response.generated_codes[counter].email);

                        var data="<div class='row'><div class='col-md-6'>"+response.generated_codes[counter].email+
                            "</div><div class='col-md-6'>"+response.generated_codes[counter].token+"</div></div>";

                        $('#container_div').append(data);

                    }

                    $('#exampleModal2').modal('show')
                }
                else
                {
                    alert("Service temporarily down, Please try again in sometime");
                }


            },
        });
    }

    function changeProfilePic() {
        $('#file_upload_div').show()

        $('#change_profile_pic_div').css("display", "none");
    }
    </script>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="logo">
                    <a hef="home.php"><img src="uploads/RUC_logo.jpg" style="max-width:auto;max-height:auto;width:80px;"></a>
                </div>
                <div class="navi">
                    <ul>
                        <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Home</span></a></li>
                        <li class="active"><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Profile</span></a></li>
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
                                <h2>Your Profile</h2>
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
                    <div class="detailsChanges">
                        <button id="editDetails" type="button" class="btn btn-success" onclick="editDetails();">Edit Details</button>
                        <button id="cancelDetails" type="button" class="btn btn-danger" onclick="cancelEditDetails();" style="display:none;">Cancel</button>
                        <button id="saveDetails" type="button" class="pull-right btn btn-primary" onclick="saveDetails();" style="display:none;">Save</button>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-12 gutter">
                            <div class="card">
                                <div class="halfLeft">
                                    <div id="change_profile_pic_div" style="margin-bottom: 10px" >
                                        <button type="button" class="btn btn-primary" style="background: #F57C00" onclick="changeProfilePic();">Change Picture</button>
                                    </div>
                                    <div id="file_upload_div" style="display: none; margin-top: 10px">Select Image to upload:
                                        <form action="updateprofilepic.php" method="post" enctype="multipart/form-data">
                                            <input type="file" name="fileToUpload" id="fileToUpload" required="required">
                                            <button type="submit" class="btn btn-primary" style="background: #F57C00; margin-top: 10px" value="POST" name="submit" onclick="uploadProfilePic();">Save</button>
                                        </form>
                                    </div>
                                    <img src="<?php echo $_SESSION['user_photo'];?>" alt="Profile Pic" class="img-rounded img-responsive" />
                                </div>

                                <div class="halfRight">
                                    <h2><?php echo $_SESSION['user_name'];?></h2>
                                    <cite title="Pittsburgh, USA"><i class="glyphicon glyphicon-map-marker">
                                    </i><input class="lived_since" type="text" id="neighbourhood" name="neighbourhood" value="Pittsburgh" readonly="readonly"></cite>
                                    <p class="profile_card">
                                        <i class="glyphicon glyphicon-calendar"></i>I've lived here for<input class="lived_since" type="text" id="lived_since" name="lived_since" value="1 year" readonly="readonly">
                                        <br />
                                        <i class="glyphicon glyphicon-gift"></i>Points:<span id="points"></span>
                                    </p>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" style="background: #F57C00" data-toggle="modal" data-target="#exampleModal">Refer a friend</button>
                                    <button type="button" class="btn btn-primary" style="background: #F57C00; margin-left:10px" onclick="getVerificationCodes();">View Verification Codes</button>
                                </div>
                                    
                            </div>


                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div style="display: flex" class="modal-header">
                                            <h5 style="width: 98%" class="modal-title" id="exampleModalLabel"><b>Enter details of your friend</b></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Name</label>
                                                    <input type="text" class="form-control" id="recipient-name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-email" class="col-form-label">Email</label>
                                                    <input type="email" class="form-control" id="recipient-email">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" onclick="generateCode();">Generate code</button>
                                        </div>
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
                                <div id="badges">
                            
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12 gutter">
                            <div class="card">
                                <h2>About Me</h2>
                                <textarea id="about" class="form-control" rows="2" cols="50" readonly="readonly" onchange="javascript:textarea_height(about, 10);"></textarea>
                            </div>
                            <div class="card">
                                <h2>My Favorite Sports/Activities</h2>
                                <textarea id="sports" readonly="readonly" class="form-control" rows="3" cols="50" onchange="javascript:textarea_height(sports, 10);"></textarea>
                            </div>
                            <div class="card">
                                <h2>My hobbies</h2>
                                <textarea id="hobbies" class="form-control" rows="2" cols="50" readonly="readonly" onchange="javascript:textarea_height(hobbies, 10);">
                                </textarea>
                            </div>
                            <div class="card">
                                <h2>My Favorite Places</h2>
                                <textarea id="places" class="form-control" rows="2" cols="50" readonly="readonly" onchange="javascript:textarea_height(places, 10);">
                                </textarea>
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