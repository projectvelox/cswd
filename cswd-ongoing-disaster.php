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
			  <li><a href="cswd-barangay-dashboard.php">Dashboard</a></li>
     		  <li class="active"><span>View Ongoing Disasters</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Ongoing Disasters</h1>
			</div><br>
				<div class="col-sm-12 col-md-12">
			      <div class="table-responsive">
					<div class="panel panel-default">
					    <div class="panel-heading">Ongoing Disasters</div>
					    	<div class="panel-body">
					    		<div class="row">
					    		<?php											
									$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
									$result = mysqli_query($con,"SELECT DISTINCT operations FROM cswd_create_relief where delivery_ended IS NULL");
										while($row = mysqli_fetch_array($result))
										{
		    								echo "<div class='col-xs-6 col-md-4'><div class='panel panel-default cswd-panel' id='cswd-create-dana'><div class='panel-body'>";
											echo "<h4>".$row['operations']."</h4>";
											echo "</div></div></div>";
										}
										mysqli_close($con);
					    		?>	
					    		</div>
					    	</div>
				    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- The Footer -->
	<?php $cswd->footer(); ?>
	<script type="text/javascript">

		//On Change of Option (Evacuation Center), the Address Changes
		$(document).ready(function(){
			$('#evacuation').change(function(){
			   var evacuation = $('select#evacuation').find(':selected').data('evacuation');
			   $.ajax({type:"POST",url:"ajax.php",
					data: {
						evacuation:evacuation,
						action: "change",
					},
				    }).then(function(data) {
				    	 $('#address').val(data);
				    }); 
			});
		});

		$(document).on("click", ".submit", function() { 
				var disaster = $('select#disaster').find(':selected').data('disaster');
				var driver = $('select#driver').find(':selected').data('driver');
				var evacuation = $('select#evacuation').find(':selected').data('evacuation');
				var packages = document.getElementById('rp').value;
				var address = document.getElementById('address').value;

				//alert(disaster + " " + driver + " " + evacuation + " " + address + " " + packages);

				$.ajax({type:"POST",url:"ajax.php",
					data: {
						disaster:disaster,
						driver:driver,
						evacuation:evacuation,
						packages:packages,
						address:address,
						action:"create_relief_operation"
					},
				    }).then(function(data) {
				    	alert("Successfully Created Relief Operations!");
				    	location.reload();
				    });
			});
		/*
		$(document).on("click", ".search", function() { 
			alert("Feature not yet available!");
		});*/
	</script>
</body>
</html>