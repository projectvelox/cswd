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
			  <li><a href="cswd-manage-accounts.php">Manage Accounts</a></li>
     		  <li class="active"><span>Accounts List</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Accounts List</h1>
			</div>
				<div class="cswd-content-container" style="padding-bottom: 0px">
					<form class="form-horizontal" action="cswd-view-accounts.php" method="POST">
					  <div class="form-group">
							<div class="input-group">
					          <span class="input-group-addon"><span class="glyphicon glyphicon-bookmark"></span> </span>
					          <input type="text" id="accounts" class="form-control" name="accounts" placeholder="Search donations">
					          <a href="#" style="color: #3c3c3c;" class="search input-group-addon"><button class="btn btn-sm lol">Search</button></a>
					        </div>
						</div>
					</form>
				</div>
				<div class="col-sm-12 col-md-12">
    			  <div class="table-responsive">
					<table class="table table-hover">
					  	<tr>
					  		<th>#</th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by First Name" href="cswd-view-accounts.php?name=firstname ASC">First Name</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Last Name" href="cswd-view-accounts.php?name=lastname ASC">Last Name</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Account Type" href="cswd-view-accounts.php?name=account_name ASC">Account Type</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Status" href="cswd-view-accounts.php?name=status ASC">Status</a></th>
					  	</tr>
					  	<?php
					  		$i=0;
					  		$x = $_GET['name'];
					  		if($x=='') { $x='id DESC';}
							$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
							$accounts = $_POST['accounts'];	
							$result = mysqli_query($con,"SELECT * FROM cswd_account_listing where (firstname like '%".$accounts."%') OR (lastname like '%".$accounts."%') OR (account_name like '%".$accounts."%') OR (status like '%".$accounts."%') ORDER BY ".mysqli_real_escape_string($con, $x)."");
								while($row = mysqli_fetch_array($result))
								{
									$i++;
									echo "<tr>";
									echo "<td>" . $i . " </td>";
									echo "<td>" . $row['firstname'] . " </td>";
									echo "<td>" . $row['lastname'] . "</td>";		
									echo "<td>" . $row['account_name'] . "</td>";
									echo "<td>" . $row['status'] . "</td>";
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