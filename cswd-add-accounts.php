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
	<?php $cswd->frontHead(); ?></head>
<body>
	
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
		        <li><a href="cswd-account-relief.php"><span class="glyphicon glyphicon-bookmark"></span> Relief Operations</a></li>
		        <li><a href="cswd-account-evacuation.php"><span class="glyphicon glyphicon-home"></span> Evacuation Center</a></li>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo "$login_fullname"?> <span class="caret"></span></a>
		          <ul class="dropdown-menu">
		            <li><a href="cswd-account-dashboard.php">Dashboard</a></li>
		            <li role="separator" class="divider"></li>
		            <li class="dropdown-header">Account</li>
		            <li><a href="cswd-account-settings.php">Settings</a></li>
		            <li><a href="logout.php">Logout</a></li>
		          </ul>
		        </li>
	        </ul>
	    </div>
	  </div>
	</nav>

	<!-- The Content -->
	<div class="container cswd-container">
		<div class="row">
			<ol class="breadcrumb breadcrumb-arrow">
			  <li><a href="cswd-account-dashboard.php">Dashboard</a></li>
			  <li><a href="cswd-manage-accounts.php">Manage Accounts</a></li>
     		  <li class="active"><span>Create Account</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Create Account</h1>
			</div>
			<div class="cswd-content-container">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<form class="form-horizontal">
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="firstname">First Name:</label>
					    <div class="col-sm-10"> 
					      <input type="text" required class="form-control" id="firstname" placeholder="Enter your firstname">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="lastname">Last Name:</label>
					    <div class="col-sm-10"> 
					      <input type="text" required class="form-control" id="lastname" placeholder="Enter your lastname">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="username">Username:</label>
					    <div class="col-sm-10"> 
					      <input type="text" required class="form-control" id="username" placeholder="Enter your preferred username">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class="control-label col-sm-2" for="ec">Type:</label>
					    <div class="col-sm-10">
						  <select class="form-control" required id="account_type">
						    <option disabled selected>Select an account type</option>
						    <?php
								$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
								$result = mysqli_query($con,"SELECT * FROM cswd_account_type");
									while($row = mysqli_fetch_array($result))
									{
										$account_type = $row['account_type'];
										$account_name = $row['account_name'];
										echo "<option data-account_type='".$account_type."'>" . $account_name .  "</option>";
									}
									echo "</table>";
									mysqli_close($con);
							?>
						  </select>
					    </div>
					  </div>
					  <div class="form-group"> 
					    <div class="col-sm-offset-2 col-sm-10">
					      <button type="button" class="btn btn-primary submit">Submit</button>
					    </div>
					  </div>
					</form>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<h4>Create an Account</h4>
					<h5><small>By default, all accounts that will be created here will automatically have the password of 'defaultpassword'. When they finally get to log in to their accounts then can it be changed.</small></h5>
				</div>
			</div>
		</div>
	</div>
	<div id="apply" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <h1 class="modal-title"></span>Successful</h1>
		      </div>
		      <div class="modal-body">
		      	<p>Successfully Created Account!</p>
		      </div>
		      <div class="modal-footer">
			      <input type="button" id="closer" name="submit" data-loading-text="Logging in..." class="btn btn-primary" value="Close" />
			   </div>
		    </div>
		  </div>
	</div>
	<!-- The Footer -->
	<?php $cswd->footer(); ?>
	<script type="text/javascript">
		$(document).on("click", ".submit", function() { 
			var account_type = $('select#account_type').find(':selected').data('account_type');
			var firstname = document.getElementById('firstname').value;
			var lastname = document.getElementById('lastname').value;
			var username = document.getElementById('username').value;

			$.ajax({type:"POST",url:"ajax.php",
				data: {
					account_type:account_type,
					firstname:firstname,
					lastname:lastname,
					username:username,
					action:"create_account"
				},
			    }).then(function(data) {
			    	$('#apply').modal('show');
			    });
		});

		$(document).on("click", "#closer", function() { $('#apply').modal('hide'); location.reload();});
	</script>
</body>
</html>