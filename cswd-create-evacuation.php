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

	<div id="addNew" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Add Evacuation Type</h4>
	      </div>
	      <div class="modal-body">
	      	<form class="form-horizontal">
	      		<div class="form-group">
			    	<label class="control-label col-sm-2" for="name">Name:</label>
			   	    <div class="col-sm-10"> 
			      		<input type="text" required class="form-control" id="name" placeholder="Enter designated name for type of evacuation">
			    	</div>
			  	</div>
			  	<div class="form-group">
				  	<label class="control-label col-sm-2" for="definition">Definition:</label>
				  	<div class="col-sm-10"> 
						<textarea class="form-control" rows="5" id="definition" placeholder="Enter its terms and definition"></textarea>
					</div>
				</div>
		      </div>
		      <div class="modal-footer">
		      <button class="btn btn-primary btn-sm newType">Create New</button>
		      </div>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- The Content -->
	<div class="container cswd-container">
		<div class="row">
			<ol class="breadcrumb breadcrumb-arrow">
			  <li><a href="cswd-account-dashboard.php">Dashboard</a></li>
			  <li><a href="cswd-manage-evacuation.php">Manage Evacuation Center</a></li>
     		  <li class="active"><span>Create Evacuation Center</span></li>
			</ol>
			<div class="cswd-header">
				<h1 style="margin-bottom: -15px;">Evacuation Type List</h1>
				<div class="text-right">
					<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addNew">Add Evacuation Type <span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
			<div class="cswd-content-container">
			<form class="form-horizontal">
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="name">Name:</label>
			    <div class="col-sm-10"> 
			      <input type="text" required class="form-control" id="name_1" placeholder="Input Evacuation Center Name">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-2" for="type">Type:</label>
			    <div class="col-sm-10">
				  <select class="form-control" required id="type">
				    <option disabled selected>Select an evacuation type</option>
				    <?php
						$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
						$result = mysqli_query($con,"SELECT * FROM cswd_evacuation_types WHERE status='Active'");
							while($row = mysqli_fetch_array($result))
							{
								$name = $row['name'];
								echo "<option data-type='".$name."'>" . $name .  "</option>";
							}
							echo "</table>";
							mysqli_close($con);
					?>
					<option>Add New</option>
				  </select>
			    </div>
			  </div>

			   <div class="form-group">
			    <label class="control-label col-sm-2" for="barangay">Barangay:</label>
			    <div class="col-sm-10">
				  <select class="form-control" required id="barangay">
				    <option disabled selected>Select a barangay</option>
				    <?php
						$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
						$result = mysqli_query($con,"SELECT * FROM barangay");
							while($row = mysqli_fetch_array($result))
							{
								$id = $row['ID'];
								$name = $row['NAME'];
								echo "<option data-barangay='".$id."'>" . $name .  "</option>";
							}
							echo "</table>";
							mysqli_close($con);
					?>
				  </select>
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="control-label col-sm-2" for="address">Complete Address:</label>
			    <div class="col-sm-10"> 
			      <input type="text" class="form-control" id="address" value="" placeholder="Input the complete address of this evacuation center">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="capacity">Max Capacity:</label>
			    <div class="col-sm-10"> 
			      <input type="number" class="form-control" id="capacity" value="" placeholder="Input the maximum capacity of this evacuation center">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="rooms">Rooms:</label>
			    <div class="col-sm-10"> 
			      <input type="number" class="form-control" id="rooms" value="" placeholder="Input the number of rooms this evacuation center have">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="toilets">Public Toilet:</label>
			    <div class="col-sm-10"> 
			      <input type="number" class="form-control" id="toilets" value="" placeholder="Input the number of public toilets this evacuation center have">
			    </div>
			  </div>
			  <div class="form-group"> 
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="button" class="btn btn-primary submit">Submit</button>
			    </div>
			  </div>
			</form>

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
		      	<p>Successfully Created Evacuation Center Profile!</p>
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
	$('#type').change(function(){
		var type = document.getElementById('type').value;
		if(type == "Add New") {
			$('#addNew').modal('show');
		}
	});	

	$("#addNew").on('hidden.bs.modal', function () {
        location.reload();
    });

	$(document).on("click", ".submit", function() { 
			var name = document.getElementById('name_1').value;
			//alert(name);
			var type = $('select#type').find(':selected').data('type');
			var barangay = $('select#barangay').find(':selected').data('barangay');
			var address = document.getElementById('address').value;
			var capacity = document.getElementById('capacity').value;
			var rooms = document.getElementById('rooms').value;
			var toilets = document.getElementById('toilets').value;
			
			$.ajax({type:"POST",url:"ajax.php",
				data: {
					name:name,
					type:type,
					barangay:barangay,
					address:address,
					capacity:capacity,
					rooms:rooms,
					toilets:toilets,
					action:"create_evacuation_center"
				},
			    }).then(function(data) {
			    	$('#apply').modal('show');
			    });

		});
	$(document).on("click", "#closer", function() { $('#apply').modal('hide'); location.reload();});
	</script>
	<script type="text/javascript">

		$(document).on("click", ".newType", function() { 
				var name = document.getElementById('name').value;
				var definition = document.getElementById('definition').value;
				
				$.ajax({type:"POST",url:"ajax.php",
					data: {
						name:name,
						definition:definition,
						action:"create_evacuation_type"
					},
				    }).then(function(data) {
				    	$('#apply').modal('show');
				    });
			});
		$(document).on("click", "#closer", function() { $('#apply').modal('hide'); location.reload();});
	</script>
</body>
</html>