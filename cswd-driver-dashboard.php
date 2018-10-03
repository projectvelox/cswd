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
		.cswd-panel:hover {
		    background-color: rgb(255, 255, 255);
		    border: 1px solid #dddddd;
		}
		.cswd-panel h4 { border-bottom: 1px solid #ddd; padding-bottom: 10px; }
		.cswd-panel h3 { margin: 0px; }
		.bordify { height: 590px; }
				
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
	      <a class="navbar-brand" href="#">CSWD</a>
	    </div>
	    <div id="navbar"  class="navbar-collapse collapse navbar-right">
	      	<ul class="nav navbar-nav">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo "$login_fullname"?> <span class="caret"></span></a>
		          <ul class="dropdown-menu">
		            <li><a href="cswd-driver-dashboard.php">Dashboard</a></li>
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
			<div class="cswd-header">
				<h1>Hi <?php echo "$login_fullname"?></h1>
			</div>
			<div class="cswd-content-container">
				<h3 class="text-center" style="margin-top: 0px;">Task List</h3>
				<?php
					$i=0; 
					$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
					$result = mysqli_query($con,"SELECT TIME_FORMAT(SEC_TO_TIME(TIMESTAMPDIFF(SECOND,delivery_started,delivery_ended)), '%H Hours %i Mins %s Seconds') AS timedude, DATE_FORMAT(task_created, '%M %D, %Y %h:%i %p') as task_createds,DATE_FORMAT(delivery_started, '%M %D, %Y %h:%i %p') as delivery_starteds,cswd_create_relief.* FROM cswd_create_relief where driver='$login_fullname' AND status='Incomplete' ORDER BY delivery_ended DESC");
					while($row = mysqli_fetch_array($result))
					{
						if($row['delivery_ended'] == NULL) {
							$i++;
							echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">';
							echo '<div class="bordify">';						
							echo '<h4 class="text-center">'.$row['evacuation_center'].'<h4>';
							echo '<img height="600" src="https://maps.googleapis.com/maps/api/staticmap?center='.$row['lat'].','.$row['lng'].'&size=400x400&zoom=15&key=AIzaSyCSnDUeTrVJn4V99qJBuT3dd01H8Nrjg6k&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C'.$row['lat'].','.$row['lng'].'" class="img-responsive" style="margin-bottom: 10px;">';				
							echo '<h4 class="text-center">Address: '.$row['address'].'</h4>';
							echo '<h5 class="text-center">Relief Packages to Deliver: '.$row['packages'].'<h5>';
							
							if($row['delivery_started']){ 
								echo '<h4 class="text-center"><small>Date Issued: '.$row['task_createds'].'</small><h4>';
								echo '<h4 class="text-center"><small>Operation Started: '.$row['delivery_starteds'].'</small><h4>';
								echo '<div style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding-top: 5px; margin-bottom: 10px;"><p class="text-center"><small style="color: #c10000">The relief operation has begun, please click the button when you reach your destination</small></p></div>';

								echo '<diV class="text-center"><button data-id='.$row['id'].' class="btn btn-primary end">End Delivery</button></div>'; 
								
							}
							else {
								echo '<h4 class="text-center"><small>Date Issued: '.$row['task_createds'].'</small><h4><hr>'; 
								echo '<diV class="text-center"><button data-id='.$row['id'].' class="btn btn-primary start">Commence Delivery</button></div>'; 
							}
							echo '</div>';
							echo '</div>';
						}
						else {
							$i++;
							echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">';
							echo '<div class="bordify" style="height: 440px;">';	
							echo '
							<h4 class="text-center">'.$row['evacuation_center'].'</h4>
							<h4 class="text-center" style="margin-top:-10px;"><small>(Fill this up to complete the operation)</small></h4>
							<p class="text-center"><small>Delivery Completed In: '.$row['timedude'].'</small></p>
							<form class="form-horizontal">
								<input type="hidden" id="evacuation_center" value="'.$row['evacuation_center'].'">
								<input type="hidden" id="disaster" value="'.$row['operations'].'">
								<div class="form-group">
							        <label class="control-label" for="packagesbrought" style="margin-bottom: 5px;">Packages Brought:</label>
							       	<input type="number" required class="form-control" id="packagesbrought" disabled value="'.$row['packages'].'">
								</div>
								<div class="form-group">
							        <label class="control-label" for="food" style="margin-bottom: 5px;">Delivery Status:</label>
							        <select class="form-control" id="decision">
							        	<option disabled selected>Select an option below</option>
										<option value="success">Successful delivery</option>
										<option value="fail">Insufficient packages</option>
									</select>
								</div>
								<div class="form-group hide" id="both">
							        <label class="control-label" for="familiesserved" style="margin-bottom: 5px;">Families Served:</label>
							       	<input type="number" required class="form-control" id="familiesserved" placeholder="Number of families served during the relief operation">
								</div>
								<div class="form-group hide" id="success">
							        <label class="control-label" for="remainingpackages" style="margin-bottom: 5px;">Remaining Packages:</label>
							       	<input type="number" required class="form-control" id="remainingpackages" placeholder="Excess packages from the relief operation">
								</div>
								<div class="form-group hide" id="fail">
							        <label class="control-label" for="unservedfamilies" style="margin-bottom: 5px;">Unserved Families:</label>
							       	<input type="number" required class="form-control" id="unservedfamilies" placeholder="Number of familes in the evacuation center unserved">
								</div>
							</form>
							';
							echo '<diV class="text-center"><button data-id='.$row['id'].' class="btn btn-primary submit">Submit Report</button></div>';				
							echo '<h4 class="text-center"><small id="form_message"></small></h4></div>';
							echo '</div>';
						}

					}
					mysqli_close($con); 
				?>
			</div>
		</div>
	</div>
	<div id="commence" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <h3 class="modal-title"></span>Commencing Operation</h3>
		      </div>
		      <div class="modal-body">
		      	<p>Commencing the Relief Operation</p>
		      </div>
		      <div class="modal-footer">
			      <input type="button" id="close" name="submit" data-loading-text="Logging in..." class="btn btn-primary dude" value="Close"/>
			   </div>
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
		      	<p>Successfully completed the relief operation!</p>
		      </div>
		      <div class="modal-footer">
			      <input type="button" id="closer" name="submit" data-loading-text="Logging in..." class="btn btn-primary dude" value="Close" />
			   </div>
		    </div>
		  </div>
	</div>
	<!-- The Footer -->
	<?php $cswd->footer(); ?>
	<script type="text/javascript">
		$(document).on("click", ".start", function() { 
			var id = $(this).data('id'); 
			$.ajax({type:"POST",url:"ajax.php",
			data: {
				id:id,
				action:"start"
			},
		    }).then(function(data) {
		    	$('#commence').modal('show');
		    });
		});

		$(document).on("click", ".end", function() { 
			var id = $(this).data('id'); 
			$.ajax({type:"POST",url:"ajax.php",
			data: {
				id:id,
				action:"end"
			},
		    }).then(function(data) {
		    	$('#apply').modal('show');
		    });
		});

		$(document).on("click", ".submit", function() { 
			var id = $(this).data('id'); 
			var disaster = document.getElementById('disaster').value;
			var evacuation_center = document.getElementById('evacuation_center').value;
			var familiesserved = document.getElementById('familiesserved').value;
			var remainingpackages = document.getElementById('remainingpackages').value;
			var unservedfamilies = document.getElementById('unservedfamilies').value;
			var decision = document.getElementById('decision').value;

			if(unservedfamilies == '') { unservedfamilies = 0;}
			if(remainingpackages == '') { remainingpackages = 0; }

			//alert(disaster + " " + evacuation_center + " " + familiesserved + " " + remainingpackages + " " + unservedfamilies);
			if(decision == 'Select an option below'){
				document.getElementById('form_message').innerHTML = "Please select an option for the delivery status!";
			} else {
				document.getElementById('form_message').innerHTML = "";
				$.ajax({type:"POST",url:"ajax.php",
				data: {
					id:id,
					disaster: disaster,
					evacuation_center:evacuation_center,
					familiesserved: familiesserved,
					remainingpackages: remainingpackages,
					unservedfamilies: unservedfamilies,
					action:"status_ec"
				},
			    }).then(function(data) {
			    	$('#apply').modal('show');
			    });
			} 

		});

		$(document).on("click", ".dude", function() { location.reload(); });

		$(document).on('change', '#decision', function() {
		  document.getElementById('form_message').innerHTML = "";
		  var decision = document.getElementById('decision').value;
		  if(decision=="success"){
		  	$("#fail").addClass("hide")
			$("#both").removeClass("hide")
			$("#success").removeClass("hide")
			$('#unservedfamilies').val('');
		  }
		  else {
		  	$("#success").addClass("hide")
		  	$("#both").removeClass("hide")
			$("#fail").removeClass("hide")
			$('#remainingpackages').val('');
		  }
		});
	</script>

</body>
</html>