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
	    <div id="navbar"  class="navbar-collapse collapse navbar-right" onmouseenter="$(this).append('D')">
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
     		  <li class="active"><span>Manage Evacuation Center</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Evacuation Center</h1>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<div class="cswd-content-container">
					<div class="panel panel-default">
				    <div class="panel-heading">Evacuation Center Management</div>
				    	<div class="panel-body">
				    		<div class="row">
				    			<div class="col-xs-12 col-md-6">
				    				<div class="panel panel-default cswd-panel" id="cswd-create-evacuation">
										<div class="panel-body">
									  		<h4><span class="glyphicon glyphicon-pencil"></span> Create Evacuation Center</h4>
									  	</div>
									</div>
				    			</div>

				    			<!--
				    			<div class="col-xs-12 col-md-6">
				    				<div class="panel panel-default cswd-panel" id="cswd-create-type">
										<div class="panel-body">
									  		<h4><span class="glyphicon glyphicon-pencil"></span> Add Evacuation Type</h4>
									  	</div>
									</div>
				    			</div> -->
				    			
				    			<div class="col-xs-12 col-md-6">
				    				<div class="panel panel-default cswd-panel" id="cswd-evacuation-list">
										<div class="panel-body">
									  		<h4><span class="glyphicon glyphicon-home"></span> Evacuation Centers List</h4>
									  	</div>
									</div>
				    			</div>				    			
				    			<div class="col-xs-12 col-md-6">
				    				<div class="panel panel-default cswd-panel" id="cswd-type-list">
										<div class="panel-body">
									  		<h4><span class="glyphicon glyphicon-home"></span> Evacuation Type List</h4>
									  	</div>
									</div>
				    			</div>
				    			<div class="col-xs-12 col-md-6">
				    				<div class="panel panel-default cswd-panel" id="cswd-currently-active">
										<div class="panel-body">
									  		<h4><span class="glyphicon glyphicon-exclamation-sign"></span> In Action</h4>
									  	</div>
									</div>
				    			</div>
				    		</div>
				    	</div>
				    </div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<h3 class="text-center" style="margin-top: 10px;">Number of Evacuation Centers per Barangay:</h3>
				<canvas id="myChart" width="400" height="400"></canvas><hr>
			</div>

		</div>
	</div>
	<!-- The Footer -->
	<?php $cswd->footer(); ?>
	<script type="text/javascript">
		
		$( "#cswd-create-evacuation" ).click(function() {
		  window.location.assign('cswd-create-evacuation.php');
		});

		$( "#cswd-create-type" ).click(function() {
		  window.location.assign('cswd-create-type.php');
		});

		$( "#cswd-type-list" ).click(function() {
		  window.location.assign('cswd-view-type.php');
		});


		$( "#cswd-evacuation-list" ).click(function() {
		  window.location.assign('cswd-view-evacuation.php');
		});

		$( "#cswd-currently-active" ).click(function() {
		  window.location.assign('cswd-currently-active.php');
		});
	</script>
	<script src="js/Chart.bundle.min.js"></script>
	<script src="js/palette.js"></script>
	<script type="text/javascript">
		var ctx = document.getElementById("myChart");
		var myChart = new Chart(ctx, {
		    type: 'doughnut',
		    data: {
		        labels: [<?php  
		        	$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
					$sql = "SELECT DISTINCT barangay_name FROM cswd_evacuation_listing ORDER BY barangay_name ASC";
			  	    $result = $con->query($sql);
			  		
			  		foreach ($result as $row)
					{
						$address = $row['barangay_name'];
				  	 	echo '"'.$address.'",';
					}
		        ?>],
		        datasets: [{
		            label: 'Number of Evacuation Centers per Barangay',
		            data: [<?php  
		        	$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
					$sql = "SELECT DISTINCT barangay_name FROM cswd_evacuation_listing ORDER BY barangay_name ASC";
			  	    $result = $con->query($sql);
			  		
			  		foreach ($result as $row)
					{
						$barangay_name = $row['barangay_name'];
				  	 	$sql1 = "SELECT COUNT(*) AS counted FROM cswd_evacuation_listing WHERE barangay_name='$barangay_name'";
				  	    $result = $con->query($sql1);
				  	    foreach ($result as $rows){
				  	 		echo '"'.$rows['counted'].'",';
				  	    }
					}
		        	?>],
		        	backgroundColor: palette('tol', [<?php  
		        	$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
					$sql = "SELECT DISTINCT barangay_name FROM cswd_evacuation_listing ORDER BY barangay_name ASC";
			  	    $result = $con->query($sql);
			  		
			  		foreach ($result as $row)
					{
						$barangay_name = $row['barangay_name'];
				  	 	$sql1 = "SELECT COUNT(*) AS counted FROM cswd_evacuation_listing WHERE barangay_name='$barangay_name'";
				  	    $result = $con->query($sql1);
				  	    foreach ($result as $rows){
				  	 		echo '"'.$rows['counted'].'",';
				  	    }
					}
		        	?>].length).map(function(hex) {
				        return '#' + hex;
				      })
		        	/*
		            backgroundColor: [
		                "#FF6384",
		                "#36A2EB",
		                "#FFCE56"
		            ],
		            hoverBackgroundColor: [
		                "#FF6384",
		                "#36A2EB",
		                "#FFCE56"
		            ],
		            borderColor: [
		                "#FF6384",
		                "#36A2EB",
		                "#FFCE56"
		            ],
		            borderWidth: 1*/
		        }]
		    },
		    options: {
		        animation:{
		            animateScale:true
		        }
		    }
		});
	</script>
</body>
</html>