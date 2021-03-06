<?php 
  include('config.php');
  include('library/library.php');
  $cswd = new cswd; 
?>
<!DOCTYPE html>
<html>
<head>
	<?php $cswd->frontHead(); ?>
</head>
<body>
	<!-- The Modal -->
	<?php $cswd->modal(); ?>

	<!-- The Navigation Bar -->
	<?php $cswd->navbar(); ?>

	<!-- The Content -->
	<div class="container cswd-container">
		<div class="row">
			<div class="cswd-header">
				<h1>Evacuation Centers</h1>
			</div>
			<div class="cswd-content-container">
				<div class="col-md-6 col-xs-12">
					<?php 
						$result = mysqli_query($con,"SELECT DISTINCT(district_name) AS district FROM cswd_evacuation_listing ORDER BY district_name ASC");
						foreach ($result as $row){			
							echo'<div id="evacuationCenter">';
							echo'<h3>District of '.$row['district'].'</h3><hr style="margin-top: 0px;">';
							$barangay = mysqli_query($con,"SELECT DISTINCT(barangay_name) AS barangay FROM cswd_evacuation_listing WHERE district_name='".$row['district']."' ORDER BY barangay_name ASC");
							foreach ($barangay as $barangay){
								$i=0;
								echo'<h4>Barangay '.$barangay['barangay'].'</h4>';
								echo'<ul class="list-group">';
								$list = mysqli_query($con,"SELECT name FROM cswd_evacuation_listing WHERE barangay_name='".$barangay['barangay']."' ORDER BY name ASC");
								foreach ($list as $listrow){ $i++; echo'<li class="list-group-item">'.$i.'. '.$listrow['name'].'</li>'; }
								echo'</ul>';
							}
							echo'</div>';
						}
					?>
				</div>
				<div class="col-md-6 col-xs-12">
					<h3>Info</h3>
					<ul class="list-group">
						<?php 
						$result = mysqli_query($con,"SELECT COUNT(DISTINCT(district_name)) AS district, COUNT(DISTINCT(barangay_name)) AS barangay, COUNT(DISTINCT(name)) AS name FROM cswd_evacuation_listing");
						$row=mysqli_fetch_assoc($result);
						echo'<li class="list-group-item"><b>Number of Districts</b><span class="badge">'.$row['district'].'</span></li>';
						echo'<li class="list-group-item"><b>Number of Barangays</b><span class="badge">'.$row['barangay'].'</span></li>';
						echo'<li class="list-group-item"><b>Number of Evacuation Centers</b><span class="badge">'.$row['name'].'</span></li>';
						?>	
					</ul>
					<h3>Evacuation Centers per District:</h3>
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
			$result = mysqli_query($con,"SELECT DISTINCT(district_name) AS district FROM cswd_evacuation_listing ORDER BY district_name ASC");
			foreach ($result as $row){
				$number = mysqli_query($con,"SELECT COUNT(name) AS name FROM cswd_evacuation_listing WHERE district_name='".$row['district']."'");
				$value=mysqli_fetch_assoc($number);	
		    	echo '{label: "'.$row['district'].'", value: '.$value['name'].'},';
		    }
		    ?>
		  ]
		});
	</script>
</body>
</html>