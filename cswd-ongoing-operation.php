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
     		  <li class="active"><span>View Ongoing Operation</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Ongoing Relief Operations</h1>
			</div>
				<div class="cswd-content-container" style="padding-bottom: 0px">
					<form class="form-horizontal" action="cswd-ongoing-operation.php" method="POST">
					  <div class="form-group">
							<div class="input-group">
							  <input type="text" class="form-control" id="relief_operations" name="relief_operations" placeholder="Search Ongoing Relief Operation">
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
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Operation" href="cswd-ongoing-operation.php?name=operations ASC">Operation</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Driver" href="cswd-ongoing-operation.php?name=driver ASC">Driver</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Evacuation Center" href="cswd-ongoing-operation.php?name=evacuation_center ASC">Evacuation Center</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Address" href="cswd-ongoing-operation.php?name=address ASC">Address</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Relief Packages" href="cswd-ongoing-operation.php?name=packages DESC">Packages</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Task Created" href="cswd-ongoing-operation.php?name=task_created DESC">Task Created</a></th>
					  	</tr>
					  	<?php
					  		$i = 0;
					  		$x = $_GET['name'];
					  		if($x=='') { $x='id';}
							$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
							$operations = $_POST['relief_operations'];	
							$result = mysqli_query($con,"SELECT * FROM cswd_create_relief WHERE (operations LIKE '%".$operations."%' OR driver LIKE '%".$operations."%' OR evacuation_center LIKE '%".$operations."%' OR address LIKE '%".$operations."%' OR packages LIKE '%".$operations."%' OR DATE_FORMAT(task_created,'%b %d %Y %h:%i %p') LIKE '%".$operations."%') AND (delivery_ended IS NULL) ORDER BY ".mysqli_real_escape_string($con, $x)."");
								while($row = mysqli_fetch_array($result))
								{
									$i++;
									$date = date('M j Y g:i A', strtotime($row['task_created']));
									echo "<tr>";
									echo "<td>" . $i . " </td>";
									echo "<td>" . $row['operations'] . " </td>";
									echo "<td>" . $row['driver'] . "</td>";
									echo "<td>" . $row['evacuation_center'] . "</td>";
									echo "<td>" . $row['address'] . "</td>";			
									echo "<td>" . $row['packages'] . "</td>";
									echo "<td>" . $date . "</td>";
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

				//alert(disaster + " " + driver + " " + evacuation + " " + address + " " + packages);

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
		/*
		$(document).on("click", ".search", function() { 
			alert("Feature not yet available!");
		});*/
	</script>
	<script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip(); 
	});
	</script>
</body>
</html>