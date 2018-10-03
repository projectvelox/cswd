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

	<!-- Content -->
	<div class="container cswd-container">
		<div class="row">
			<div class="cswd-header">
				<h1>Hello <?php echo "$login_fullname"?>!</h1>
				<h2 style="margin-top: -5px"><small><?php echo "$login_access_level"?></small></h2> 
			</div>
			<div class="cswd-content-container">
				<div class="panel panel-default">
			    <div class="panel-heading">Management</div>
			    	<div class="panel-body">
			    		<div class="row">
			    			<div class="col-xs-12 col-md-6">
			    				<div class="panel panel-default cswd-panel" id="cswd-manage-accounts">
									<div class="panel-body">
								  		<h4><span class="glyphicon glyphicon-user"></span> Manage Accounts</h4>
								  	</div>
								</div>
			    			</div> <!-- Hidden Module
			    			<div class="col-xs-12 col-md-6">
			    				<div class="panel panel-default cswd-panel" id="cswd-manage-donations">
									<div class="panel-body">
								  		<h4><span class="glyphicon glyphicon-usd"></span> Manage Donations</h4>
								  	</div>
								</div>
			    			</div> -->
			    			<div class="col-xs-12 col-md-6">
			    				<div class="panel panel-default cswd-panel" id="cswd-manage-evacuation">
									<div class="panel-body">
								  		<h4><span class="glyphicon glyphicon-home"></span> Evacuation Center</h4>
								  	</div>
								</div>
			    			</div>
			    			<div class="col-xs-12 col-md-6">
			    				<div class="panel panel-default cswd-panel" id="cswd-manage-relief">
									<div class="panel-body">
								  		<h4><span class="glyphicon glyphicon-bookmark"></span> Manage Relief Operations</h4>
								  	</div>
								</div>
			    			</div>

			    			<div class="col-xs-12 col-md-6">
			    				<div class="panel panel-default cswd-panel" id="cswd-reports">
									<div class="panel-body">
								  		<h4><span class="glyphicon glyphicon-list-alt"></span> Reports</h4>
								  	</div>
								</div>
			    			</div>

			    		</div>
			    	</div>
			    </div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php $cswd->footer(); ?>

	<script type="text/javascript">
		$( "#cswd-manage-relief" ).click(function() {
		  window.location.assign('cswd-manage-relief.php');
		});

		$( "#cswd-manage-donations" ).click(function() {
		  window.location.assign('cswd-manage-donations.php');
		});

		$( "#cswd-manage-evacuation" ).click(function() {
		  window.location.assign('cswd-manage-evacuation.php');
		});

		$( "#cswd-manage-accounts" ).click(function() {
		  window.location.assign('cswd-manage-accounts.php');
		});

		$( "#cswd-reports" ).click(function() {
		  window.location.assign('cswd-reports.php');
		});
	</script>

</body>
</html>