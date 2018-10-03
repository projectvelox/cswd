<?php 
  date_default_timezone_set('Asia/Manila');
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
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>Social Welfare and Development</title>
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/carousel.css"/>
	<link rel="stylesheet" href="css/front-design.css"/>
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"/>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet" media="print" /> 
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
</head>
<body onload="start()" style="height: auto;">
	<style type="text/css"> ::-webkit-scrollbar { display: none; } </style>
	<h3 class="text-center">Evacuation Center Usage for the Year of <?php echo $_GET['year']; ?></h3>
	<div class="table-responsive">
		<table class="table">
		  	<tr>
		  		<th>#</th>
		  		<th>Evacuation Center</th>
		  		<th>Address</th>
		  		<th>Total Packages Recieved</th>
		  		<th>Total Usage for the Year</th>
		  	</tr>
		  	<?php
		  		$i=0;
		  		$year = $_GET['year'];
				$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
				$sql = "SELECT evacuation_center, COUNT(evacuation_center) total_usage, address, SUM(packages) AS total_package FROM cswd_create_relief WHERE YEAR(delivery_ended)='$year' AND delivery_ended IS NOT NULL GROUP BY evacuation_center";
					$result = mysqli_query($con,$sql);
					while($row = mysqli_fetch_array($result))
					{
						$i++;
						echo "<tr>";
						echo "<td>" . $i . "</td>";
						echo "<td>" . $row['evacuation_center'] . "</td>";
						echo "<td>" . $row['address'] . "</td>";
						echo "<td>" . $row['total_package'] . " Packages</td>";
						echo "<td>" . $row['total_usage'] . " Times This Year</td>";			
						echo "</tr>";
					}
					mysqli_close($con);
			?>
		  </table>
		</div>
		<div class="table-responsive">
		<table class="table">
		  	<tr>
		  		<th>#</th>
		  		<th>Evacuation Center</th>
		  		<th>Address</th>
		  		<th>Number of Packages Recieved</th>
		  		<th>Delivery Date</th>
		  		<th>Families</th>
		  		<th>Evacuees</th>
		  	</tr>
		  	<?php
		  		$i=0;
		  		$year = $_GET['year'];
				$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
				$sql = "SELECT DATE_FORMAT(delivery_ended,'%M %D, %Y %h:%i %p') AS delivery_endeds,cswd_create_relief.* FROM cswd_create_relief WHERE YEAR(delivery_ended)='$year'AND delivery_ended IS NOT NULL";
					$result = mysqli_query($con,$sql);
					while($row = mysqli_fetch_array($result))
					{
						$i++;
						echo "<tr>";
						echo "<td>" . $i . "</td>";
						echo "<td>" . $row['evacuation_center'] . "</td>";
						echo "<td>" . $row['address'] . "</td>";
						echo "<td>" . $row['packages'] . " Packages</td>";
						echo "<td>" . $row['delivery_endeds'] . "</td>";	
						echo "<td>" . $row['family'] . "</td>";		
						echo "<td>" . $row['evacuees'] . "</td>";				
						echo "</tr>";
					}
					mysqli_close($con);
			?>
		  </table>
		</div>
		<br><br><p class="text-center"><i>Evacuation center usage for the year of <?php echo $_GET['year'];  ?></i></p>
		<script type="text/javascript">	function start() { 	window.print(); } </script>
</body>
</html>