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

	<!-- The Content -->
	<div class="container cswd-container">
		<div class="row">
			<ol class="breadcrumb breadcrumb-arrow">
			  <li><a href="cswd-account-dashboard.php">Dashboard</a></li>
     		  <li class="active"><span>Manage Donations</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Donations</h1>
			</div>
			<div class="cswd-content-container">
				<div class="panel panel-default">
			    <div class="panel-heading">Donations Management</div>
			    	<div class="panel-body">
			    		<div class="row">
			    			<div class="col-xs-12 col-md-6">
			    				<div class="panel panel-default cswd-panel" id="cswd-add-donation">
									<div class="panel-body">
								  		<h4><span class="glyphicon glyphicon-pencil"></span> Add Donations</h4>
								  	</div>
								</div>
			    			</div>
			    			<div class="col-xs-12 col-md-6">
			    				<div class="panel panel-default cswd-panel" id="cswd-view-donation">
									<div class="panel-body">
								  		<h4><span class="glyphicon glyphicon-book"></span> View Donations</h4>
								  	</div>
								</div>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
	<!-- The Footer -->
	<?php $cswd->footer(); ?>
	<script type="text/javascript">
		
		$( "#cswd-add-donation" ).click(function() {
		  window.location.assign('cswd-add-donation.php');
		});

		$( "#cswd-view-donation" ).click(function() {
		  window.location.assign('cswd-view-donation.php');
		});

	</script>
</body>
</html>