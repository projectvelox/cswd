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
	$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
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
			  <li><a href="cswd-manage-evacuation.php">Manage Evacuation Centers</a></li>
     		  <li class="active"><span>in Action</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Evacuation Center in Action</h1>
			</div>
				<div class="cswd-content-container" style="padding-bottom: 0px">
					<form class="form-horizontal" action="cswd-currently-active.php" method="POST">
					    <div class="form-group">
					        <div class="input-group">
							  <input type="text" class="form-control" id="evacuation" name="evacuation" placeholder="Search Evacuation Center">
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
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Evacuation Center Name" href="cswd-currently-active.php?name=evacuation_center">Evacuation Center Name</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Address" href="cswd-currently-active.php?name=address">Address</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Ongoing Disaster" href="cswd-currently-active.php">Ongoing Disaster</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Number of Evacuees" href="cswd-currently-active.php">Number of Evacuees</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Maximum Capacity" href="cswd-currently-active.php">Maximum Capacity</a></th>
					  		<th><a href="cswd-currently-active.php">Available Capacity</a></th>
					  	</tr>
					  	<?php 
					  		$i=0;
					  		$x = $_GET['name'];
					  		if($x=='') { $x='evacuation_center';}
					  		$sql = "SELECT DISTINCT evacuation_center, address, operations,disasterid, evacid FROM cswd_create_relief 
								WHERE (delivery_ended IS NULL AND evacuation_center like '%".$evacuation."%') 
								OR (delivery_ended IS NULL AND address like '%".$evacuation."%') 
								OR (delivery_ended IS NULL AND operations like '%".$evacuation."%')ORDER BY ".mysqli_real_escape_string($con, $x)." ASC";
							$result = $con->query($sql);					  		
					  		foreach ($result as $row)
							{
								$i++;
								echo "<tr>";
								echo "<td>" . $i . "</td>";	
								echo "<td>" . $row['evacuation_center'] . "</td>";
								echo "<td>" . $row['address'] . "</td>";
								echo "<td>" . $row['operations'] . "</td>";
								$sql1 = "SELECT * FROM evacuation_report WHERE DECLAREID=".$row['disasterid']." AND EVACID=".$row['evacid']." ORDER BY DATEADDED DESC LIMIT 1";
								$result1 = $con->query($sql1);
								foreach ($result1 as $row1){ echo "<td>" . $row1['SRVPERSONS'] . "</td>"; }
								
								$sql2 = "SELECT * FROM cswd_evacuation_listing WHERE name='".$row['evacuation_center']."'";
								$result2 = $con->query($sql2);
								foreach ($result2 as $row2){ echo "<td>" . $row2['capacity'] . "</td>"; }

								$remaining = $row2['capacity'] - $row1['SRVPERSONS'];
								echo "<td>" . $remaining . "</td>";
								echo "</tr>";
							}
					  	?>
					  	<?php
					  		/*$i=0;
					  		$x = $_GET['name'];
					  		if($x=='') { $x='evacuation_center';}
							
							$evacuation = $_POST['evacuation'];	
							$result = mysqli_query($con,"SELECT DISTINCT evacuation_center, address, operations FROM cswd_create_relief 
								WHERE (delivery_ended IS NULL AND evacuation_center like '%".$evacuation."%') 
								OR (delivery_ended IS NULL AND address like '%".$evacuation."%') 
								OR (delivery_ended IS NULL AND operations like '%".$evacuation."%')ORDER BY ".mysqli_real_escape_string($con, $x)." ASC");
								while($row = mysqli_fetch_array($result))
								{	
									$i++;
									echo "<tr>";
									echo "<td>" . $i . "</td>";	
									echo "<td>" . $row['evacuation_center'] . "</td>";
									echo "<td>" . $row['address'] . "</td>";
									echo "<td>" . $row['operations'] . "</td>";
									echo "<td> 40 </td>";
									echo "<td> 50 </td>";
									echo "<td> 10 </td>";
									echo "</tr>";
								}
								echo "</table>";
								mysqli_close($con); */
						?>
					  </table>
				</div>
			</div>
		</div>
	</div>
	<!-- The Footer -->
	<?php $cswd->footer(); ?>
	<script type="text/javascript">
	</script>
</body>
</html>