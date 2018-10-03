<?php 
  include('session.php');
  include('config.php');
  include('library/library.php');
  $cswd = new cswd; 

    if(!isset($_SESSION['login_user'])){
      header("location:index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php $cswd->frontHead(); ?>
</head>
<body>
    <style type="text/css">
        .footer { top: 81px; }
        .footer-bottom { position: relative; top: 81px; }
        .input-group span {min-width: 15rem;}
    </style>
    <!-- The Navigation Bar -->
    <nav class="navbar navbar-inverse navbar-fixed-top"> 
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="cswd-account-index.php">CSWD</a>
        </div>
        <div id="navbar"  class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <?php
                if($login_access_level == "CSWD") {
                    echo "<li><a href='cswd-account-relief.php'><span class='glyphicon glyphicon-bookmark'></span> Relief Operations</a></li>
                          <li><a href='cswd-account-evacuation.php'><span class='glyphicon glyphicon-home'></span> Evacuation Center</a></li>";
                }
                ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo "$login_fullname"?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                   <?php 
                        if($login_access_level == "CSWD") {
                            echo "<li><a href='cswd-account-dashboard.php'>Dashboard</a></li>";
                        }
                        if($login_access_level == "CSWD Driver"){
                            echo "<li><a href='cswd-driver-dashboard.php'>Dashboard</a></li>";
                        }
                    ?>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Account</li>
                    <li><a href='cswd-account-settings.php'>Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                  </ul>
                </li>
            </ul>
        </div>
      </div>
    </nav>

    <!-- Content Starts Here -->    
    <div class="container cswd-container">
        <div class="row">
            <div class="cswd-header">
                <h1>Update Account  <small> for account <i><?php echo "$login_fullname"?></i></small> </h1>
            </div>
            <div class="cswd-content-container">
                <div class="row">
                    <div class="col-lg-6">
                        <form class="form-horizontal">
                            <!-- Old Password -->
                            <div class="input-group">
                                <span class="input-group-addon">Old Password: </span>
                                <input type="password" id="password" name="password" maxlength="50" class="form-control" required />
                            </div>
                            <br />

                            <!-- New Password -->
                            <div class="input-group">
                                <span class="input-group-addon">New Password: </span>
                                <input type="password" id="newpassword" name="newpassword" maxlength="50" class="form-control" required />
                            </div>
                            <br />

                            <!-- New Password 2 -->
                            <div class="input-group">
                                <span class="input-group-addon">Retype New Password: </span>
                                <input type="password" id="reconfirm" name="reconfirm" maxlength="50" class="form-control" required />
                            </div>
                            <br />

                            <!-- Submission -->
                            <button type="button" data-loading-text="Update Account..." class="btn btn-primary pull-right submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php $cswd->footer(); ?>
    <script type="text/javascript">
        $(document).on("click", ".submit", function() { 
            var password = document.getElementById('password').value;
            var newpassword = document.getElementById('newpassword').value;
            var reconfirm = document.getElementById('reconfirm').value;

            $.ajax({type:"POST",url:"ajax.php",
                data: {
                    password:password,
                    newpassword:newpassword,
                    reconfirm:reconfirm,
                    action:"update_password"
                },
                }).then(function(data) {
                    if(data == "Successfully updated your password!")
                    {
                        alert(data);
                        location.reload();
                    }
                    else { alert(data); }
                });
        });
    </script>
</body>
</html>

