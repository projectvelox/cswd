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
			<div class="cswd-header">
				<h1>Relief Operations</h1>
			</div>
			<div class="cswd-content-container">
				<div class="col-md-6 col-xs-12">
					<?php 
						$result = mysqli_query($con,"SELECT CONCAT(MONTHNAME(delivery_ended), ' ', YEAR(delivery_ended)) AS themonth, COUNT(operations) FROM cswd_create_relief GROUP BY MONTHNAME(delivery_ended), YEAR(delivery_ended) ORDER BY MONTHNAME(delivery_ended) DESC");
						foreach ($result as $row){			
							echo'<div id="evacuationCenter">';
							echo'<h3>'.$row['themonth'].'</h3><hr style="margin-top: 0px;">';
								$i=0;
								echo'<ul class="list-group">';
								$list = mysqli_query($con,"SELECT CONCAT(MONTHNAME(delivery_ended), ' ', YEAR(delivery_ended)) AS themonth, evacuation_center, DATE_FORMAT(delivery_ended,'%M %D, %Y %h:%i %p') AS delivery_endeds, driver, CONCAT(packages, ' Packages Delivered') AS total_packages FROM cswd_create_relief WHERE CONCAT(MONTHNAME(delivery_ended), ' ', YEAR(delivery_ended)) ='".$row['themonth']."'");
								foreach ($list as $listrow){ $i++; echo'<li class="list-group-item">'.$i.'. '.$listrow['evacuation_center'].' - '.$listrow['delivery_endeds'].' - (Driver '.$listrow['driver'].')</li>'; }
								echo'</ul>';
							echo'</div>';
							}
							
					?>
				</div>
				<div class="col-md-6 col-xs-12">
					<h3>Info</h3>
					<ul class="list-group">
						<?php $result = mysqli_query($con,"SELECT CONCAT(MONTHNAME(delivery_ended), ' ', YEAR(delivery_ended)) AS themonth, SUM(packages) AS totalpackages FROM cswd_create_relief WHERE delivery_ended IS NOT NULL GROUP BY MONTHNAME(delivery_ended), YEAR(delivery_ended)");
						foreach ($result as $row){ echo'<li class="list-group-item"><b>Total Packages Delivered for '.$row['themonth'].'</b><span class="badge"> '.$row['totalpackages'].' Packages</span></li>'; }?>	
					</ul>
					<h3>Relief Operations</h3>
					<div id="donut-example" style="width: 19em !important; margin: 0px auto;">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- The Footer -->
	<?php $cswd->footer(); ?>
	<script type="text/javascript">
		Morris.Donut({
		  element: 'donut-example',
		  data: [
		  		<?php 
					$result = mysqli_query($con,"SELECT CONCAT(MONTHNAME(delivery_ended), ' ', YEAR(delivery_ended)) AS themonth, SUM(packages) AS totalpackages FROM cswd_create_relief WHERE delivery_ended IS NOT NULL GROUP BY MONTHNAME(delivery_ended), YEAR(delivery_ended) ORDER BY MONTHNAME(delivery_ended) DESC");
					foreach ($result as $row){			
			    		echo '{ label: "'.$row['themonth'].'", value: '.$row['totalpackages'].'},';
		    		}
		    	?>
		  ]
		});
	</script>
</body>
</html>