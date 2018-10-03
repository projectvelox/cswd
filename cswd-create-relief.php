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
	<style type="text/css">.cswd-recommended-label { margin-bottom: 5px !important; margin-left: -15px; } </style>
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
			  <li><a href="cswd-manage-relief.php">Manage Relief Operations</a></li>
     		  <li class="active"><span>Create Relief Operation</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Create Relief Operations</h1>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<div class="cswd-content-container">
					<form class="form-horizontal">
						<h4><span class="glyphicon glyphicon-bookmark"></span> Relief Operation Details</h4>
					  	<div class="form-group">
					    	<label class="control-label col-sm-2" for="operation">Operation:</label>
					    	<div class="col-sm-10">
						  		<select class="form-control" required id="disaster">
						    	<option disabled selected>Choose an ongoing disaster</option>
						    	<?php
								$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
								$result = mysqli_query($con, "SELECT disaster_type.NAME AS NAME1, disaster_declare . * , barangay.NAME AS NAME2 FROM disaster_declare INNER JOIN barangay ON barangay.ID = disaster_declare.BRGY INNER JOIN disaster_type ON disaster_type.ID = disaster_declare.DISASTER WHERE ENDED IS NULL OR ENDED BETWEEN NOW( ) AND DATE_ADD( NOW( ) , INTERVAL 14 DAY ) LIMIT 0 , 30");
									while($row = mysqli_fetch_array($result))
									{
										$disaster = $row['ID'];
										$name =  $row['NAME2'] . " - " . $row['NAME1'] . " (" . $row['NICKNAME']. ")";
										echo "<option data-disasterid='".$disaster."' data-disaster='".$name."' >".$row['NAME2']." - ".$row['NAME1']." (".$row['NICKNAME'].")</option>";
									}
									echo "</table>";
									mysqli_close($con);
								?>
						  		</select>
					    	</div>
					  	</div>
					   	<div class="form-group">
					    	<label class="control-label col-sm-2" for="driver">Driver:</label>
					    	<div class="col-sm-10">
						  		<select class="form-control" required id="driver">
						    	<option disabled selected>Assign a driver for the relief operation</option>
						    	<?php
								$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
								$result = mysqli_query($con,"SELECT * FROM cswd_account_listing where account_name = 'CSWD Driver'");
									while($row = mysqli_fetch_array($result))
									{
										$username = $row['username'];
										$fullname = $row['firstname'] . " " . $row['lastname'];
										echo "<option data-username='".$username."' data-driver='".$fullname."'>" . $fullname .  "</option>";
									}
									echo "</table>";
									mysqli_close($con);
								?>
								</select>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label class="control-label col-sm-2" for="ec">Center:</label>
					    	<div class="col-sm-10">
						  		<select class="form-control" required id="evacuation">
						  		</select>
					    		<!-- Start New Edit Here -->
								<div class="hide alert alert-danger" id="hidden" style="margin-top: 10px; margin-bottom: 0px; padding: 10px;">
									Unserved families based on previous operation: <span id="unserved"></span>
								</div>
								<!-- End Edit Here -->

					    	</div>
					  	</div>
					  	<input type="hidden" id='lat'><input type="hidden" id="lng">
					  	<div class="form-group">
					    	<label class="control-label col-sm-2" for="driver">Address:</label>
					    	<div class="col-sm-10"> 
					      		<input type="text" class="form-control" id="address" disabled value="">
					    	</div>
					  	</div>
					  	<div class="form-group">
					    <label class="control-label col-sm-2" for="rp">Packages:</label>
					    	<div class="col-sm-10"> 
					      		<input type="number" required class="form-control" id="rp" placeholder="Input how many packages driver will deliver">
					    	</div>
					  	</div><hr>
					  	<!-- This is for the new recommendations -->
					  	<h4><span class="glyphicon glyphicon-user"></span> Number of Evacuees, Families, Sex, and PWD</h4>
					  	<div class="form-group">
					     	<label class="control-label col-sm-2" for="people">Evacuees:</label>
					     	<div class="col-sm-10">  
					       		<input type="number" required class="form-control" id="people" disabled placeholder="Number of evacuees based on the latest report">
					     	</div>
					  	</div>
					  	<div class="form-group">
					     	<label class="control-label col-sm-2" for="family">Families:</label>
					     	<div class="col-sm-10">  
					       		<input type="number" required class="form-control" id="family" disabled placeholder="Number of families based on the latest report">
					     	</div>
					  	</div>
					  	<div class="form-group">
					    	<label class="control-label col-sm-2" for="male">Male:</label>
					     	<div class="col-sm-10">  
					       		<input type="number" required class="form-control" id="male" disabled placeholder="Number of males in the evacuation center">
					     	</div>
					  	</div>
					  	<div class="form-group">
					    	<label class="control-label col-sm-2" for="female">Female:</label>
					      	<div class="col-sm-10">  
					       		<input type="number" required class="form-control" id="female" disabled placeholder="Number of females in the evacuation center">
					      	</div>
					  	</div>
					  	<div class="form-group">
					    	<label class="control-label col-sm-2" for="pwd">PWD:</label>
					      	<div class="col-sm-10">  
					       		<input type="number" required class="form-control" id="pwd" disabled placeholder="Number of PWDs in the evacuation center">
					      	</div>
					  	</div><hr>
					  	<h4><span class="glyphicon glyphicon-stats"></span> Age Bracket</h4>
					  	<div class="form-group">
					    	<div class="col-sm-2"></div>
					      	<div class="col-sm-10">
					      		<div class="row">
					      			<div class="col-xs-12 col-md-6">
					      				<label class="control-label">Male</label>
					      			</div>
					      			<div class="col-xs-12 col-md-6">
					      				<label class="control-label">Female</label>
					      			</div>
					      		</div>  
					      	</div>
					  	</div>
					  	<div class="form-group">
					    	<label class="control-label col-sm-2" for="infant">Child:</label>
					      	<div class="col-sm-10">
					      		<div class="row">
					      			<div class="col-xs-12 col-md-6">
					      				<input type="number" required class="form-control" id="maleChild" placeholder="Number of Male Child" disabled>
					      			</div>
					      			<div class="col-xs-12 col-md-6">
					      				<input type="number" required class="form-control" id="femaleChild" placeholder="Number of Female Child" disabled>
					      			</div>
					      		</div>  
					      	</div>
					  	</div>
					  	<div class="form-group">
					    	<label class="control-label col-sm-2" for="adult">Teen:</label>
					      	<div class="col-sm-10">
					      		<div class="row">
					      			<div class="col-xs-12 col-md-6">
					      				<input type="number" required class="form-control" id="maleTeen" placeholder="Number of Male Teens" disabled>
					      			</div>
					      			<div class="col-xs-12 col-md-6">
					      				<input type="number" required class="form-control" id="femaleTeen" placeholder="Number of Female Teens" disabled>
					      			</div>
					      		</div>  
					      	</div>
					    </div>
					  	<div class="form-group">
					  		
					    	<label class="control-label col-sm-2" for="adult">Adult:</label>
					      	<div class="col-sm-10">  
						       	<div class="row">
						  			<div class="col-xs-12 col-md-6">
						  				<input type="number" required class="form-control" id="maleAdult" placeholder="Number of Male Adults" disabled>
						  			</div>
						  			<div class="col-xs-12 col-md-6">
						  				<input type="number" required class="form-control" id="femaleAdult" placeholder="Number of Female Adults" disabled>
						  			</div>
						  		</div>	
					      	</div>
					    </div>
					    <div class="form-group">
					    	<label class="control-label col-sm-2" for="elder">Senior:</label>
					      	<div class="col-sm-10"> 
					      		<div class="row">
						    		<div class="col-xs-12 col-md-6">
						    			<input type="number" required class="form-control" id="maleSenior" placeholder="Number of Male Senior" disabled>
						    		</div>
						    		<div class="col-xs-12 col-md-6">
						    			<input type="number" required class="form-control" id="femaleSenior" placeholder="Number of Female Senior" disabled>
						    		</div>
						    	</div> 
					     	 </div>
					    </div>
					  	<!-- End Here -->
					  	<div class="form-group"> 
					    	<div class="col-sm-offset-2 col-sm-10">
					      		<button type="button" class="btn btn-primary submit">Submit</button>
					    	</div>
					  	</div>
					</form>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<h4 style="margin-top: 30px;"><span class="glyphicon glyphicon-bookmark"></span> Relief Operations</h4>
				<h4><small>This page is where the CSWD can assign tasks to drivers. Here they can identify which driver will go to which evacuation center and how many packages they will deliver.</small></h4>
				<br>
				<h4><small><strong>Age Bracket:</strong><br>Child: 0 Months - 12 Years Old<br>Teen: 13 Years Old - 19 Years Old<br>Adult: 20 Years Old - 59 Years Old<br>Senior: 60 Years Old and above</small></h4><hr>

				<!-- Start New Edit Here -->
				<div class="hide" id="hidden">
					<h4><span class="glyphicon glyphicon-home"></span> Evacuation Center: <span id="unservedec"></span></h4>
					<h5>Unserved families based on previous operation: <span id="unserved"></span></h5><hr>
				</div>
				<!-- End Edit Here -->
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
		      	<p>Successfully Created Relief Operation!</p>
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
		//On Change of Option (Evacuation Center), the Address Changes
		$(document).ready(function(){
			$('#driver').change(function(){
			   	var driver = $('select#driver').find(':selected').data('driver');
			  	var disasterid = $('#disaster').find(':selected').data('disasterid');
			  	$.ajax({type:"POST",url:"ajax.php",
			   		data: {
			   			driver:driver,
						disasterid:disasterid,
			   			action: "shet"
			   		},
				    }).then(function(data) {
				    	 $('#evacuation').html(data);
				    }); 

			});			
			$('#evacuation').change(function(){
				var disasterid = $('#disaster').find(':selected').data('disasterid');
				var disaster = $('select#disaster').find(':selected').data('disaster');
			   	var evacuation = $('select#evacuation').find(':selected').data('evacuation');
			   	var evacid = $('select#evacuation').find(':selected').data('evacid');
			   	$.ajax({type:"POST",url:"ajax.php",
					data: {
						evacuation:evacuation,
						action: "HolyShitHopeThisWorks",
					},
				    }).then(function(data) {
				    	var age = data.split(",");
				    	$('#maleChild').val(age[0]);
				    	$('#femaleChild').val(age[1]);
				    	$('#maleTeen').val(age[2]);
				    	$('#femaleTeen').val(age[3]);
				    	$('#maleAdult').val(age[4]);
				    	$('#femaleAdult').val(age[5]);
				    	$('#maleSenior').val(age[6]);
				    	$('#femaleSenior').val(age[7]);
				    	$('#male').val(age[8]);
				    	$('#female').val(age[9]);
				    	$('#pwd').val(age[10]);
				    });

			  	$.ajax({type:"POST",url:"ajax.php",
					data: {
						evacuation:evacuation,
						action: "change_evacuation",
					},
				    }).then(function(data) {
				    	 $('#address').val(data);
				    });

			   	$.ajax({type:"POST",url:"ajax.php",
					data: {
						evacuation:evacuation,
						action: "latlng",
					},
				    }).then(function(data) {
				    	var latlang = data.split(",");
				    	$('#lat').val(latlang[0]);
				    	$('#lng').val(latlang[1]);
				    });

				$.ajax({type:"POST",url:"ajax.php",
					data: {
						disasterid:disasterid,
						evacid:evacid,
						action: "automatefamily",
					},
				    }).then(function(data) {
				    	var familyperson = data.split(",");
				    	$('#family').val(familyperson[0]);
				    	$('#people').val(familyperson[1]);
				    });

				$.ajax({type:"POST",url:"ajax.php",
					data: {
						evacuation:evacuation,
						disaster:disaster,
						action: "getstatus",
					},
				    }).then(function(data) {
				    	if(data=='Null'){ $("#hidden").addClass("hide");}
				    	else {
				    		var ecstatus = data.split(",");
				    		if(ecstatus[1] == 0){ $("#hidden").addClass("hide"); }
				    		else {
				    			$("#hidden").removeClass("hide")
				    			var ecstatus = data.split(",");
				    			document.getElementById('unservedec').innerHTML = ecstatus[0];
				    			document.getElementById('unserved').innerHTML = ecstatus[1];
				    		}
				    	}
				    });           
			});
		});
		$(document).on("click", ".submit", function() { 
				var disasterid = $('select#disaster').find(':selected').data('disasterid');
				var evacid = $('select#evacuation').find(':selected').data('evacid');
				var disaster = $('select#disaster').find(':selected').data('disaster');
				var driver = $('select#driver').find(':selected').data('driver');
				var username = $('select#driver').find(':selected').data('username');
				var evacuation = $('select#evacuation').find(':selected').data('evacuation');
				var packages = document.getElementById('rp').value;
				var address = document.getElementById('address').value;
				var lat = document.getElementById('lat').value;
				var lng = document.getElementById('lng').value;
				var people = document.getElementById('people').value;
				var family = document.getElementById('family').value;
				var male = document.getElementById('male').value;
				var female = document.getElementById('female').value;
				var maleChild = document.getElementById('maleChild').value;
				var femaleChild = document.getElementById('femaleChild').value;
				var maleTeen = document.getElementById('maleTeen').value;
				var femaleTeen = document.getElementById('femaleTeen').value;
				var maleAdult = document.getElementById('maleAdult').value;
				var femaleAdult = document.getElementById('femaleAdult').value;
				var maleSenior = document.getElementById('maleSenior').value;
				var femaleSenior = document.getElementById('femaleSenior').value;
				var pwd = document.getElementById('pwd').value;
				$.ajax({type:"POST",url:"ajax.php",
					data: {
						disasterid:disasterid,
						evacid:evacid,
						disaster:disaster,
						driver:driver,
						username:username,
						evacuation:evacuation,
						packages:packages,
						address:address,
						people:people,
						family:family,
						male:male,
						female:female,
						maleChild:maleChild,
						femaleChild:femaleChild,
						maleTeen:maleTeen,
						femaleTeen:femaleTeen,
						maleAdult:maleAdult,
						femaleAdult:femaleAdult,
						maleSenior:maleSenior,
						femaleSenior:femaleSenior,
						pwd:pwd,
						lat:lat,
						lng:lng,
						action:"create_relief_operation"
					},
				    }).then(function(data) {
				    	$('#apply').modal('show');
				    });
			});
		$(document).on("click", "#closer", function() { $('#apply').modal('hide'); location.reload();});
	</script>
</body>
</html>