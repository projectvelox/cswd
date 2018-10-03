<?php 
	error_reporting(0);
	ini_set('display_errors', 0);
	include('config.php');
	include('library/library.php');
	$cswd = new cswd; 
	session_start();	
?>
<!DOCTYPE html>
<html>
<head>
	<?php $cswd->frontHead(); ?>
</head>
<body>
	<style type="text/css">::-webkit-scrollbar { display: none; }</style>
	<!-- The Modal -->
	<?php $cswd->modal(); ?>

	<!-- The Navigation Bar -->
	<?php $cswd->navbar(); ?>

	<!-- Carousel -->
	<?php $cswd->carousel(); ?>

	<!-- Search Bar -->
	<?php $cswd->frontSearch(); ?>

	<!-- Content -->
	<div class="container">
		<div class="row cswd-status-container">
			<div class="col-md-6">
				<section>
					<h4><i class="glyphicon glyphicon-home"></i> Evacuation Center</h4>
					<ul> 
					<?php
					$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
					$result = mysqli_query($con,"SELECT * FROM evacuation_list LIMIT 5");
						while($row = mysqli_fetch_array($result))
						{
							$evacuation = $row['EVACNAME'];
							echo "<li><a href='#' rel='bookmark'>". $evacuation ."</a></li>";
						}
						echo "</ul>";
					?>
					<a href="cswd-evacuation.php" class="button secondary tiny">more</a>
				</section>
			</div>
			<div class="col-md-6">
				<section>
					<h4><i class="glyphicon glyphicon-bookmark"></i> Relief Operations</h4>
					<ul>
						<li><a href="cswd-relief.php" rel="bookmark">Operation Frank</a></li>
						<li><a href="cswd-relief.php" rel="bookmark">Operation Yolanda</a></li>
						<li><a href="cswd-relief.php" rel="bookmark">Operation Ruby</a></li>
						<li><a href="cswd-relief.php" rel="bookmark">Operation Fire Storm</a></li>
						<li><a href="cswd-relief.php" rel="bookmark">Operation Earth Shaker</a></li>
					</ul>
					<a href="cswd-relief.php" class="button secondary tiny">more</a>
				</section>
			</div>
		</div>
		<div class="cswd-header-container">
			<h2 style="text-align: center;">The City Social Welfare and Development Office</h2>
			<p>We provide intervention/opportunities that will uplift the living conditions of the distressed and disadvantaged individuals, Families, groups and communities and enable them to become self-reliant and actively participate in national development</p>
		</div>
		<div id="cswd-m-and-v">
			<div class="row">
				<div class="col-md-6">
					<section id="cswd-mission">
						<h4><i class="glyphicon glyphicon-book"></i> Mission</h4>
						<p>To provide intervention/opportunities that will uplift the living conditions of the distressed and disadvantaged individuals, Families, groups and communities and enable them to become self-reliant and actively participate in national development.</p>
					</section>
				</div>
				<div class="col-md-6">
					<section id="cswd-vision">
						<h4><i class="glyphicon glyphicon-globe"></i> Vision</h4>
						<p>To provide a society where the poor, vulnerable and disadvantaged families and communities are empowered for an improved quality of life.</p>
					</section>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php $cswd->footer(); ?>
	
</body>
</html>