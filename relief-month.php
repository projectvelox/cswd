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
<style type="text/css"> ::-webkit-scrollbar { display: none; } </style>
<body onload="start()" style="height: auto;">
	<h3 class="text-center">Relief Operations for the Month of <?php echo $_GET['month']; ?></h3>
	<div class="table-responsive">
		<table class="table">
		  	<tr>
		  		<th>#</th>
		  		<th>Operation</th>
		  		<th>Driver</th>
		  		<th>Evacuation Center</th>
		  		<th>Address</th>
		  		<th>Packages</th>
		  		<th>Delivery Started</th>
		  		<th>Delivery Ended</th>
		  		<th>Evacuees</th>
		  		<th>Families</th>
		  	</tr>
		  	<?php
		  		$i=0;
		  		$month = $_GET['month'];
				$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
				$sql = "SELECT DATE_FORMAT(delivery_ended, '%M %D, %Y %h:%i %p') AS delivery_endeds, DATE_FORMAT(delivery_started, '%M %D, %Y %h:%i %p') AS delivery_starteds, cswd_create_relief.* FROM cswd_create_relief WHERE CONCAT(MONTHNAME(delivery_ended), ' ', YEAR(delivery_ended))='$month'";
					$result = mysqli_query($con,$sql);
					while($row = mysqli_fetch_array($result))
					{
						$i++;
						echo "<tr>";
						echo "<td>" . $i . "</td>";
						echo "<td>" . $row['operations'] . "</td>";
						echo "<td>" . $row['driver'] . "</td>";
						echo "<td>" . $row['evacuation_center'] . "</td>";
						echo "<td>" . $row['address'] . "</td>";			
						echo "<td>" . $row['packages'] . "</td>";
						echo "<td>" . $row['delivery_starteds'] . "</td>";
						echo "<td>" . $row['delivery_endeds'] . "</td>";
						echo "<td>" . $row['evacuees'] . "</td>";
						echo "<td>" . $row['family'] . "</td>";
						echo "</tr>";
					}
					mysqli_close($con);
			?>
		  </table>
		</div>
		<br><br><p class="text-center"><i>List of relief operations for the month of <?php echo $_GET['month']; ?></i></p>
		<script type="text/javascript">	function start() { 	window.print(); } </script>
</body>
</html>