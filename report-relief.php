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
	<h3 class="text-center">Relief Operations</h3>
	<div class="table-responsive">
		<table class="table">
		  	<tr>
		  		<th>#</th>
		  		<th>Year</th>
		  		<th>Month</th>
		  		<th>Number of Relief Operations</th>
		  		<th>Packages Delivered</th>
		  	</tr>
		  	<?php
		  		$i=0;
				$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");

				$sql = "SELECT COUNT(*) AS total_count, YEAR(delivery_ended) AS year, MONTHNAME(delivery_ended) AS month, SUM(packages) AS total_packages FROM cswd_create_relief WHERE delivery_ended IS NOT NULL GROUP BY month(delivery_ended) ";
					$result = mysqli_query($con,$sql);
					while($row = mysqli_fetch_array($result))
					{
						$i++;
						echo "<tr>";
						echo "<td>" . $i . "</td>";
						echo "<td>" . $row['year'] . "</td>";
						echo "<td>" . $row['month'] . "</td>";
						echo "<td>" . $row['total_count'] . "</td>";
						echo "<td>" . $row['total_packages'] . "</td>";			
						echo "</tr>";
					}
					mysqli_close($con);
			?>
		  </table>
		</div>
		<br><br><p class="text-center"><i>Updated list as of <?php echo $today = date("F j, Y - g:iA");  ?></i></p>
		<script type="text/javascript">	function start() { 	window.print(); } </script>
</body>
</html>