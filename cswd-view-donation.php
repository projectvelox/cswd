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
			  <li><a href="cswd-manage-donations.php">Manage Donations</a></li>
     		  <li class="active"><span>Recent Donations</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Recent Donations</h1>
			</div>
				<div class="cswd-content-container" style="padding-bottom: 0px">
					<form class="form-horizontal" action="cswd-view-donation.php" method="POST">
					  <div class="form-group">
							<div class="input-group">
					          <span class="input-group-addon"><span class="glyphicon glyphicon-bookmark"></span> </span>
					          <input type="text" id="recent_donations" class="form-control" name="recent_donations" placeholder="Search donations">
					          <a href="#" style="color: #3c3c3c;" class="search input-group-addon"><button class="btn btn-sm lol">Search</button></a>
					        </div>
						</div>
					</form>
				</div>
				<div class="col-sm-12 col-md-12">
    			  <div class="table-responsive">
					<table class="table table-hover">
					  	<tr>
					  		<th>Donor</th>
					  		<th>Evacuation Center</th>
					  		<th>Address</th>
					  		<th>Type</th>
					  		<th>Particulars</th>
					  		<th>Quantity</th>
					  		<th>Unit</th>
					  		<th>Date</th>	
					  	</tr>
					  	<?php
							$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
							$recent_donations = $_POST['recent_donations'];	
							$result = mysqli_query($con,"SELECT * FROM cswd_donations where (donation_type like '%".$recent_donations."%') OR (donor_name like '%".$recent_donations."%') OR (evacuation_center like '%".$recent_donations."%') OR (address like '%".$recent_donations."%') OR (particulars like '%".$recent_donations."%') OR (quantity like '%".$recent_donations."%') OR (unit like '%".$recent_donations."%') OR (donation_date like '%".$recent_donations."%')");
								while($row = mysqli_fetch_array($result))
								{
									$date = date('M j Y g:i A', strtotime($row['donation_date']));
									echo "<tr>";
									echo "<td>" . $row['donor_name'] . " </td>";
									echo "<td>" . $row['evacuation_center'] . "</td>";
									echo "<td>" . $row['address'] . "</td>";
									echo "<td>" . $row['donation_type'] . "</td>";			
									echo "<td>" . $row['particulars'] . "</td>";
									echo "<td>" . $row['quantity'] . "</td>";
									echo "<td>" . $row['unit'] . "</td>";
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
	</script>
</body>
</html>