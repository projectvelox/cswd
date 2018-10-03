<?php 
  	include('session.php');
  	include('config.php');
  	include('library/library.php');
  	$cswd = new cswd; 
	if(!isset($_SESSION['login_user'])){ header("location:index.php"); }
	$x = $_GET['name'];
	$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
	$result = mysqli_query($con,"SELECT DATE_FORMAT(date_added, '%M %D, %Y - %h:%i %p') AS date_addeds, cswd_evacuation_listing.* FROM cswd_evacuation_listing where name = '$x'");
	$row=mysqli_fetch_assoc($result);
	$type = $row['evacuation_type'];
	$barangay_name = $row['barangay_name'];
	$address = $row['address'];
	$lat = $row['lat'];
	$lng = $row['lng'];
	$capacity = $row['capacity'];
	$toilets = $row['toilets'];
	$rooms = $row['rooms'];
	$date_added = $row['date_addeds'];
?>

<!DOCTYPE html>
<html>
<head>
	<?php $cswd->frontHead(); ?>
</head>
<body>
	<style type="text/css"> 
		.bordify { margin-bottom: 0px; } 
		#padding-zero { padding-right: 0px; }
		@media screen and (max-width: 767px) { #padding-zero { padding-right: 15px; }}
		.form-horizontal .form-group { margin-right: 0px; margin-left: 0px; }
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
			  <li><a href="cswd-view-evacuation.php">Go Back</a></li>
     		  <li><a href="cswd-evacuation-profile.php?name=<?php echo $x;?>"><?php echo $x; ?></a></li>
			</ol>
			<div class="cswd-header">
				<h1><?php echo $x; ?></h1>
			</div>

			<!-- This is for the basic details on the left side of the page -->
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="bordify" style="margin-top: 10px;">
					<h4><strong>Basic Details</strong></h4>
					<h5><strong>Name: </strong><?php echo $x;?></h5>
					<h5><strong>Type: </strong><?php echo $type;?></h5><hr>

					<h4><strong>Evacuation Center Details</strong></h4>
					<h5><strong>Capacity: </strong><?php echo $capacity;?> Evacuees</h5>
					<h5><strong>Toilets: </strong><?php echo $toilets;?> Toilets</h5>
					<h5><strong>Rooms: </strong><?php echo $rooms;?> Rooms</h5><hr>
					<p class="text-center"><small><strong>Date Created: </strong><?php echo $date_added;?></small></p>
				</div>
				<div class="bordify" style="margin-top: 10px;">
					<h4 class="text-center"><strong><?php echo $x;?></strong></h4>
					<img height="600" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $lat .",".$lng; ?>&size=400x400&zoom=15&key=AIzaSyCSnDUeTrVJn4V99qJBuT3dd01H8Nrjg6k&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C<?php echo $lat .",".$lng; ?>" class="img-responsive center-block"><hr>
					<h4><strong>Address Details</strong></h4>
					<h5><strong>Address: </strong><?php echo $address;?></h5>
					<h5><strong>Barangay: </strong><?php echo $barangay_name;?></h5>
				</div>
			</div>
			<!-- End the div here -->

			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<div class="bordify" style="margin-top: 10px;">
					<h3>
					<?php
						$condition = mysqli_query($con,"SELECT DATE_FORMAT(DATECREATED, '%M %D, %Y - %h:%i %p') AS report,disaster_declare.* FROM disaster_declare where ENDED IS NULL OR ENDED BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 14 DAY)");
						$statement=mysqli_fetch_assoc($condition);

						if($statement['ENDED'] == ''){
							$result = mysqli_query($con,"SELECT GROUP_CONCAT(DISTINCT(operations) ORDER BY id DESC) AS operations FROM cswd_create_relief WHERE (delivery_ended IS NULL OR delivery_ended > NOW() - INTERVAL 2 WEEK) AND evacuation_center='$x' ORDER BY id DESC");
							$row=mysqli_fetch_assoc($result);

							if($row['operations']) { 
								echo "Status: Currently Being Used</h3><h4><small>Disaster Name: ".$row['operations']."</small></h4></div>";
								//Status Row 
								$resultss = mysqli_query($con,"SELECT evacuation_center, DATE_FORMAT(task_created, '%M %D, %Y - %h:%i %p') AS task_date, cswd_create_relief.* FROM cswd_create_relief 
								WHERE (delivery_ended IS NULL OR delivery_ended > NOW() - INTERVAL 2 WEEK) AND evacuation_center='$x' ORDER BY id DESC LIMIT 1");
								$total=mysqli_fetch_assoc($resultss);

								//Convert the latest array as disaster
								$disaster = explode(",", $row['operations']);
								$convert = strstr($disaster[0], '(');
								$finalconversion = str_replace(str_split('()'),"",$convert);
								//End conversion

								$report = mysqli_query($con,"SELECT DATE_FORMAT(DATECREATED, '%M %D, %Y - %h:%i %p') AS report,disaster_declare.* FROM disaster_declare WHERE NICKNAME='$finalconversion'");
								$datereported=mysqli_fetch_assoc($report);
								echo '<h4 class="text-center" style="margin-top: 20px;">Status Report as of '. $datereported['report'] .'</h4><hr style="margin-top: 0px; margin-bottom: 0px;">';
								echo '<div class="row">';
								
								echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" id="padding-zero">';
								echo '<div class="bordify" style="margin-top: 10px;">';
								echo '<h4 class="text-center"><strong>Evacuees</strong></h4>';
								echo '<h4 class="text-center"><small>'.$total['evacuees'].' / '.$capacity.' Evacuees</small></h4>';
								echo '</div>'; 
								echo '</div>';

								echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" id="padding-zero">';
								echo '<div class="bordify" style="margin-top: 10px;">';
								echo '<h4 class="text-center"><strong>Families</strong></h4>';
								echo '<h4 class="text-center"><small>'.$total['family'].' Families</small></h4>';
								echo '</div>'; 
								echo '</div>';

								echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">';
								echo '<div class="bordify" style="margin-top: 10px;">';
								echo '<h4 class="text-center"><strong>Male</strong></h4>';
								echo '<h4 class="text-center"><small>'.$total['male'].' Males in Total</small></h4>';
								echo '</div>'; 
								echo '</div>';

								echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" id="padding-zero">';
								echo '<div class="bordify" style="margin-top: 10px;">';
								echo '<h4 class="text-center"><strong>Female</strong></h4>';
								echo '<h4 class="text-center"><small>'.$total['female'].' Females in Total</small></h4>';
								echo '</div>'; 
								echo '</div>';

								echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4"  id="padding-zero">';
								echo '<div class="bordify" style="margin-top: 10px;">';
								echo '<h4 class="text-center"><strong>Child</strong></h4>';
								echo '<h4 class="text-center"><small>'.$total['maleChild'].' Male / ' . $total['femaleChild'] . ' Female</small></h4>';
								echo '</div>'; 
								echo '</div>';

								echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">';
								echo '<div class="bordify" style="margin-top: 10px;">';
								echo '<h4 class="text-center"><strong>Teens</strong></h4>';
								echo '<h4 class="text-center"><small>'.$total['maleTeen'].' Male / ' . $total['femaleTeen'] . ' Female</small></h4>';
								echo '</div>'; 
								echo '</div>';

								echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" id="padding-zero">';
								echo '<div class="bordify" style="margin-top: 10px;">';
								echo '<h4 class="text-center"><strong>Adults</strong></h4>';
								echo '<h4 class="text-center"><small>'.$total['maleAdult'].' Male / ' . $total['femaleAdult'] . ' Female</small></h4>';
								echo '</div>'; 
								echo '</div>';

								echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" id="padding-zero">';
								echo '<div class="bordify" style="margin-top: 10px;">';
								echo '<h4 class="text-center"><strong>Seniors</strong></h4>';
								echo '<h4 class="text-center"><small>'.$total['maleSenior'].' Male / ' . $total['femaleSenior'] . ' Female</small></h4>';
								echo '</div>'; 
								echo '</div>';  

								echo '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">';
								echo '<div class="bordify" style="margin-top: 10px;">';
								echo '<h4 class="text-center"><strong>PWD</strong></h4>';
								echo '<h4 class="text-center"><small>'.$total['pwd'].' Disabled</small></h4>';
								echo '</div>'; 
								echo '</div>';   

								echo '</div>';
								//End Status Row
								//Ongoing Operations to Apocalyptic Evacuation Center
								echo '<div class="bordify" style="margin-top: 10px;">';
								$results = mysqli_query($con,"SELECT evacuation_center, DATE_FORMAT(task_created, '%M %D, %Y - %h:%i %p') AS task_date, cswd_create_relief.* FROM cswd_create_relief WHERE (delivery_ended IS NULL AND evacuation_center='$x')");								
								echo '<h4><strong>Ongoing Operations to '.$x.'</strong></h4>';
								echo '<div class="table-responsive">';
								echo '<table class="table">';
								echo '<tr>';
								echo '<th>Driver</th>';
								echo '<th>Packages</th>';
								echo '<th>Task Issued</th>';
								echo '</tr>';
								while($rows = mysqli_fetch_array($results))
								{
									echo '<tr>';
									echo '<td>'.$rows['driver'].'</td>';
									echo '<td>'.$rows['packages'].' Packages</td>';
									echo '<td>'.$rows['task_date'].'</td>';
									echo '</tr>';								
								}
								echo '</table>';
								$sumofpackages = mysqli_query($con, "SELECT SUM(packages)AS packages FROM cswd_create_relief WHERE (delivery_ended IS NULL AND evacuation_center='$x')");
								$packagessum=mysqli_fetch_assoc($sumofpackages);
								if($packagessum['packages']=='') { $packagessum['packages'] = 'No'; }
								echo '<h6><strong>Total Packages: '.$packagessum['packages'].' packages are going to be delivered.</strong></h6>';
								echo '</div>';
								echo '</div>'; 

								//Completed Operations 
								echo '<div class="bordify" style="margin-top: 10px;">';
								$results = mysqli_query($con,"SELECT evacuation_center, DATE_FORMAT(delivery_started, '%M %D, %Y - %h:%i %p') AS started, DATE_FORMAT(delivery_ended, '%M %D, %Y - %h:%i %p') AS ended, cswd_create_relief.* FROM cswd_create_relief 
								WHERE (delivery_ended IS NOT NULL AND evacuation_center='$x')");								
								echo '<h4><strong>Completed Operations</strong></h4>';
								echo '<div class="table-responsive">';
								echo '<table class="table">';
								echo '<tr>';
								echo '<th>Driver</th>';
								echo '<th>Packages</th>';
								echo '<th>Delivery Started</th>';
								echo '<th>Delivery Ended</th>';
								echo '</tr>';
								while($rows = mysqli_fetch_array($results))
								{
									echo '<tr>';
									echo '<td>'.$rows['driver'].'</td>';
									echo '<td>'.$rows['packages'].' Packages</td>';
									echo '<td>'.$rows['started'].'</td>';
									echo '<td>'.$rows['ended'].'</td>';
									echo '</tr>';								
								}
								echo '</table>';
								$sumofpackages = mysqli_query($con, "SELECT SUM(packages) AS packages FROM cswd_create_relief WHERE (delivery_ended IS NOT NULL AND evacuation_center='$x')");
								$packagessum=mysqli_fetch_assoc($sumofpackages);
								if($packagessum['packages']=='') { $packagessum['packages'] = '0'; }
								echo '<h6><strong>Total Packages: '.$packagessum['packages'].' packages recieved.</strong></h6>';
								echo '</div>';
								echo '</div>'; 
								

								echo '<div class="bordify" style="margin-top: 10px;">
								<h4><strong>'.$x.' Statistical Chart</strong></h4>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<h5 class="text-center" style="margin-top: 10px;"><strong>Males and Females in Evacuation Center</strong></h5>
											<canvas id="myChart" width="400" height="400"></canvas>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<h5 class="text-center" style="margin-top: 10px;"><strong>Age Bracket in Evacuation Center</strong></h5>
											<canvas id="myChart1" width="400" height="400"></canvas>
										</div>
									</div>
								</div>';
								//Codes above here has been updated

								/* <div class="row">
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<h5 class="text-center" style="margin-top: 10px;"><strong>Ongoing and Completed Relief Operations</strong></h5>
										<canvas id="myChart2" width="400" height="400"></canvas>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<h5 class="text-center" style="margin-top: 10px;"><strong>Evacuees in Evacuation Center</strong></h5>
										<canvas id="myChart3" width="400" height="400"></canvas>
									</div>
								</div> */

							}
							else { echo "Status: Not Being Used</h3></div>"; }
						}
						else {
							$result = mysqli_query($con,"SELECT DISTINCT operations FROM cswd_create_relief WHERE (delivery_ended IS NULL AND evacuation_center='$x')");
							echo $x.' Post Disaster Rehabilitation Form</h3></div>';
							while($row = mysqli_fetch_array($result)){
							echo '<div class="bordify" style="margin-top: 10px;">
								<h4>For '.$row['operations'].'</h4>
								<form class="form-horizontal">
									<div class="form-group">
										<input type="hidden" id="evacuation_center" value='.$x.'>
										<input type="hidden" id="disaster" value="'.$row['operations'].'">
								        <label class="control-label" for="relatives" style="margin-bottom: 5px;">How many families left the Evacuation Center and Stayed with their Relatives: </label>
								       	<input type="number" required class="form-control" id="relatives" placeholder="Number of families who left for their relatives">
									</div>
									<div class="form-group">
								        <label class="control-label" for="house" style="margin-bottom: 5px;">How many families are having their houses fixed:</label>
								       	<input type="number" required class="form-control" id="house" placeholder="Number of families having their houses fixed">
									</div>
									<div class="form-group">
								        <label class="control-label" for="home" style="margin-bottom: 5px;">How many families left the Evacuation Center and went back home:</label>
								       	<input type="number" required class="form-control" id="home" placeholder="Number of those who went home">
									</div>
									<div class="form-group">
								        <label class="control-label" for="stayers" style="margin-bottom: 5px;">How many familes are still at the Evacuation Center:</label>
								       	<input type="number" required class="form-control" id="stayers" placeholder="Number of those who still at the evacuation center">
									</div>
									<div class="text-right"><a href="cswd-evacuation-profile.php?name='.$x.'" class="btn btn-primary submit">Submit Form</a></div>
								</form></div>
							';
							}
						} 
					?>
				
			</div>
		</div>
	</div>
	<div id="apply" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <h3 class="modal-title"></span>Successful</h3>
		      </div>
		      <div class="modal-body">
		      	<p>Successfully completed the post disaster rehabilitation form!</p>
		      </div>
		      <div class="modal-footer">
			      <input type="button" id="closer" name="submit" data-loading-text="Logging in..." class="btn btn-primary dude" value="Close" />
			   </div>
		    </div>
		  </div>
	</div>
	<!-- The Footer -->
	<?php $cswd->footer(); ?>

	<script src="js/Chart.bundle.min.js"></script>
	<script src="js/palette.js"></script>
	<script type="text/javascript">
		var ctx = document.getElementById("myChart");
		var myChart = new Chart(ctx, {
		    type: 'doughnut',
		    data: {
		        labels: ["Male", "Female"],
		        datasets: [{
		            label: 'Sex',
		            data: [<?php $sql = "SELECT male, female FROM cswd_create_relief WHERE ((delivery_ended IS NULL OR delivery_ended > NOW() - INTERVAL 2 WEEK) AND evacuation_center='$x') ORDER BY task_created DESC LIMIT 1";
			  	    $result = $con->query($sql);
			  	    $row=mysqli_fetch_assoc($result);
				  	echo '"'.$row['male'].'","'.$row['female'].'"'; ?>],
		        	backgroundColor:  palette('tol', [150, 50].length).map(function(hex) {
				        return '#' + hex;
				    })
		        }]
		    }
		});
	</script>
	<script type="text/javascript">
		var ctx = document.getElementById("myChart1");
		var myChart = new Chart(ctx, {
		    type: 'doughnut',
		    data: {
		        labels: ["Child", "Teens", "Adults", "Seniors"],
		        datasets: [{
		            label: 'Age Bracket',
		            data: [<?php $sql = "SELECT (maleChild + femaleChild) AS child, (maleTeen + femaleTeen) AS teen, (maleAdult + femaleAdult) AS adult,(maleSenior + femaleSenior) AS senior FROM cswd_create_relief WHERE ((delivery_ended IS NULL OR delivery_ended > NOW() - INTERVAL 2 WEEK) AND evacuation_center='$x') ORDER BY task_created DESC LIMIT 1";
			  	    $result = $con->query($sql);
			  	    $row=mysqli_fetch_assoc($result);
				  	echo '"'.$row['child'].'","'.$row['teen'].'","'.$row['adult'].'","'.$row['senior'].'"'; ?>],
		        	backgroundColor:  palette('tol', [10, 180, 10].length).map(function(hex) {
				        return '#' + hex;
				    })
		        }]
		    }
		});
	</script>
	<script type="text/javascript">
		$(document).on("click", ".submit", function() { 
			var relatives = document.getElementById('relatives').value;
			var house = document.getElementById('house').value;
			var home = document.getElementById('home').value;
			var stayers = document.getElementById('stayers').value;
			var evacuation_center = document.getElementById('evacuation_center').value;
			var disaster = document.getElementById('disaster').value;

			$.ajax({type:"POST",url:"ajax.php",
			data: {
				relatives:relatives,
				house:house,
				home:home,
				stayers:stayers,
				evacuation_center:evacuation_center,
				disaster:disaster,
				action:"post_rehab"
			},
		    }).then(function(data) {
		    	$('#apply').modal('show');
		    });
		});
		$(document).on("click", ".dude", function() { location.reload(); });
	</script>
</body>
</html>