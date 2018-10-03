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
<head><?php $cswd->frontHead(); ?></head>
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
     		  <li class="active"><span>Evacuation Centers</span></li>
			</ol>
			<div class="cswd-header"><h1>Evacuation Centers</h1></div>
				<div class="cswd-content-container" style="padding-bottom: 0px">
					<form class="form-horizontal" action="cswd-view-evacuation.php" method="POST">
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
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Name" href="cswd-view-evacuation.php?name=name ASC">Name</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Type" href="cswd-view-evacuation.php?name=evacuation_type ASC">Type</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Barangay" href="cswd-view-evacuation.php?name=barangay_name ASC">Barangay</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Address" href="cswd-view-evacuation.php?name=address ASC">Address</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Capacity" href="cswd-view-evacuation.php?name=capacity DESC">Capacity</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Rooms" href="cswd-view-evacuation.php?name=rooms DESC">Rooms</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Toilets" href="cswd-view-evacuation.php?name=toilets DESC">Toilets</a></th>
					  	</tr>
					  	<?php
					  		$i=0;
					  		$x = $_GET['name'];
					  		if($x=='') { $x='name';}
							$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
							$evacuation = $_POST['evacuation'];

							$sql = "SELECT * FROM cswd_evacuation_listing WHERE (name LIKE '%".$evacuation."%') OR (evacuation_type LIKE '%".$evacuation."%') OR (barangay_name LIKE '%".$evacuation."%') OR (address LIKE '%".$evacuation."%') OR (capacity LIKE '%".$evacuation."%') OR (rooms LIKE '%".$evacuation."%')  OR (toilets LIKE '%".$evacuation."%') ORDER BY ".mysqli_real_escape_string($con, $x)."";
								$result = mysqli_query($con,$sql);
								while($row = mysqli_fetch_array($result))
								{
									$i++;
									echo "<tr>";
									echo "<td>" . $i . "</td>";
									echo "<td><a href='cswd-evacuation-profile.php?name=".$row['name']."'>" . $row['name'] . "</a></td>";
									echo "<td>" . $row['evacuation_type'] . "</td>";
									echo "<td>" . $row['barangay_name'] . "</td>";
									echo "<td>" . $row['address'] . "</td>";			
									echo "<td>" . $row['capacity'] . "</td>";
									echo "<td>" . $row['rooms'] . "</td>";
									echo "<td>" . $row['toilets'] . "</td>";
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
	<script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip(); 
	});
	</script>
</body>
</html>