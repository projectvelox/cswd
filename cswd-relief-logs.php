<?php 
  error_reporting(0);
  ini_set('display_errors', 0);
  
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
	<style type="text/css" media="print">
	.dontprintme { display: none; }
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
			<ol class="breadcrumb breadcrumb-arrow dontprintme">
			  <li><a href="cswd-account-dashboard.php">Dashboard</a></li>
			  <li><a href="cswd-manage-relief.php">Manage Relief Operations</a></li>
     		  <li class="active"><span>View Logs</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Relief Operations Logs</h1>
			</div>
				<div class="cswd-content-container" style="padding-bottom: 0px">
					<form class="form-horizontal" action="cswd-relief-logs.php" method="POST">
						<div class="form-group">
					        <div class="input-group">
							  <input type="text" class="form-control" id="relief_operations" name="relief_operations" placeholder="Search Completed Relief Operation">
							  <span class="input-group-btn">
							    <button class="btn btn-default" type="submit">Search</button>
							  </span>
							</div>
						</div>
					</form>
				</div>
				<div class="col-sm-12 col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
					  	<tr>
					  		<th>#</th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Operation" href="cswd-relief-logs.php?name=operations ASC">Operation</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Driver" href="cswd-relief-logs.php?name=driver ASC">Driver</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Evacuation Center" href="cswd-relief-logs.php?name=evacuation_center ASC">Evacuation Center</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Packages" href="cswd-relief-logs.php?name=packages DESC">Packages</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Date Started" href="cswd-relief-logs.php?name=delivery_started DESC">Started</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Date Ended" href="cswd-relief-logs.php?name=delivery_ended DESC">Ended</a></th>
					  	</tr>
					  	<?php
					  		$i=0;
					  		$x = $_GET['name'];
					  		if($x=='') { $x='delivery_started';}
							$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
							$operations = $_POST['relief_operations'];	
							$result = mysqli_query($con,"SELECT * FROM cswd_create_relief WHERE (driver LIKE '%".$operations."%' OR evacuation_center LIKE '%".$operations."%' OR operations LIKE '%".$operations."%' OR packages LIKE '%".$operations."%' OR DATE_FORMAT(delivery_started,'%b %d %Y %h:%i %p') LIKE '%".$operations."%' OR DATE_FORMAT(delivery_ended,'%b %d %Y %h:%i %p') LIKE '%".$operations."%') AND delivery_started IS NOT NULL AND delivery_ended IS NOT NULL ORDER BY ".mysqli_real_escape_string($con, $x)."");
								while($row = mysqli_fetch_array($result))
								{
									$i++;
									$date_start = date('M j Y g:i A', strtotime($row['delivery_started']));
									$date_end= date('M j Y g:i A', strtotime($row['delivery_ended']));
									echo "<tr>";
									echo "<td>" . $i . " </td>";
									echo "<td>" . $row['operations'] . " </td>";
									echo "<td>" . $row['driver'] . "</td>";
									echo "<td>" . $row['evacuation_center'] . "</td>";
									echo "<td>" . $row['packages'] . "</td>";			
									echo "<td>" . $date_start . "</td>";
									echo "<td>" . $date_end . "</td>";
									echo "</tr>";
								}
								echo "</table>";
								mysqli_close($con);
						?>
					  </table>
				</div>
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
						action: "change",
					},
				    }).then(function(data) {
				    	 $('#address').val(data);
				    }); 
			});
		});

		$(document).on("click", ".submit", function() { 
				var disaster = $('select#disaster').find(':selected').data('disaster');
				var driver = $('select#driver').find(':selected').data('driver');
				var evacuation = $('select#evacuation').find(':selected').data('evacuation');
				var packages = document.getElementById('rp').value;
				var address = document.getElementById('address').value;

				$.ajax({type:"POST",url:"ajax.php",
					data: {
						disaster:disaster,
						driver:driver,
						evacuation:evacuation,
						packages:packages,
						address:address,
						action:"create_relief_operation"
					},
				    }).then(function(data) {
				    	alert("Successfully Created Relief Operations!");
				    	location.reload();
				    });
			});
	
	</script>
	<script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip(); 
	});
	</script>
</body>
</html>