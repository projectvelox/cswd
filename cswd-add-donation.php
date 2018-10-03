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
			  <li><a href="cswd-manage-donations.php">Manage Donations</a></li>
     		  <li class="active"><span>Add Donations</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Add Donations</h1>
			</div>
			<div class="cswd-content-container">
			<form class="form-horizontal">

			  <div class="form-group">
			    <label class="control-label col-sm-2" for="rp">Name:</label>
			    <div class="col-sm-10"> 
			      <input type="text" required class="form-control" id="name" placeholder="Input the name of the donor">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="ec">Evacuation Center:</label>
			    <div class="col-sm-10">
				  <select class="form-control" required id="evacuation">
				    <option disabled selected>Assign an evacuation center</option>
				    <?php
						$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
						$result = mysqli_query($con,"SELECT * FROM evacuation_list");
							echo "<option data-evacuation='Leave it to CSWD'>Leave it to CSWD</option>";
							while($row = mysqli_fetch_array($result))
							{
								$evacuation = $row['EVACNAME'];
								echo "<option data-evacuation='".$evacuation."'>" . $evacuation .  "</option>";
							}
							echo "</table>";
							mysqli_close($con);
					?>
				  </select>
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="driver">Address:</label>
			    <div class="col-sm-10"> 
			      <input type="text" class="form-control" id="address" disabled value="">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="rp">Donation:</label>
			    <div class="col-sm-10"> 
			      <select class="form-control" required id="donation">
				    <option disabled selected>Select an option</option>
				    <?php
						$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
						$result = mysqli_query($con,"SELECT * FROM cswd_donations_type");
							while($row = mysqli_fetch_array($result))
							{
								$donation_name = $row['donation_name'];
								echo "<option data-donationtype='".$donation_name."'>" . $donation_name .  "</option>";
							}
							echo "</table>";
							mysqli_close($con);
					?>
				  </select>
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="particulars">Particulars:</label>
			    <div class="col-sm-10"> 
			      <input type="text" class="form-control" id="particulars" placeholder="Input the particulars being donated">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="quantity">Quantity:</label>
			    <div class="col-sm-10"> 
			      <input type="number" class="form-control" id="quantity" placeholder="Input the quantity">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="unit">Unit of Measurement:</label>
			    <div class="col-sm-10"> 
			      <select class="form-control" required id="unit">
				    <option disabled selected>Select an option</option>
				    <?php
						$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
						$result = mysqli_query($con,"SELECT * FROM cswd_unit");
							while($row = mysqli_fetch_array($result))
							{
								$unit = $row['unit_name'];
								echo "<option data-unit='".$unit."'>" . $unit .  "</option>";
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
		</div>
	</div>
	<!-- The Footer -->
	<?php $cswd->footer(); ?>
	<script type="text/javascript">
		//On Change of Option (Evacuation Center), the Address Changes
		$(document).ready(function(){
			$('#evacuation').change(function(){
			   var evacuation = $('select#evacuation').find(':selected').data('evacuation');
			   $.ajax({type:"POST",url:"ajax.php",
					data: {
						evacuation:evacuation,
						action: "change_evacuation",
					},
				    }).then(function(data) {
				    	 $('#address').val(data);
				    }); 
			});

			$('#donation').change(function(){
			   var donation = $('select#donation').find(':selected').data('donationtype');
			   $.ajax({type:"POST",url:"ajax.php",
					data: {
						donation:donation,
						action: "change_donation",
					},
				    }).then(function(data) {

				    }); 
			});

		});

		$(document).on("click", ".submit", function() { 
				var donor = document.getElementById('name').value;
				var evacuation = $('select#evacuation').find(':selected').data('evacuation');
				var address = document.getElementById('address').value;
				var donation = $('select#donation').find(':selected').data('donationtype');
				var particulars = document.getElementById('particulars').value;
				var quantity = document.getElementById('quantity').value;
				var unit = $('select#unit').find(':selected').data('unit');

				//alert(disaster + " " + driver + " " + evacuation + " " + address + " " + packages);

				$.ajax({type:"POST",url:"ajax.php",
					data: {
						donor:donor,
						evacuation:evacuation,
						address:address,
						donation:donation,
						particulars:particulars,
						quantity:quantity,
						unit:unit,
						action:"add_donations"
					},
				    }).then(function(data) {
				    	alert("Successfully Added Donations!");
				    	location.reload();
				    });
			});
	</script>
</body>
</html>