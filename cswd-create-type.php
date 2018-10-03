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
			  <li><a href="cswd-manage-evacuation.php">Manage Evacuation Center</a></li>
     		  <li class="active"><span>Add Evacuation Type</span></li>
			</ol>
			<div class="cswd-header">
				<h1>Add Evacuation Type</h1>
			</div>
				<div class="cswd-content-container">
				<form class="form-horizontal">
				  	<div class="form-group">
				    	<label class="control-label col-sm-2" for="name">Name:</label>
				   	    <div class="col-sm-10"> 
				      		<input type="text" required class="form-control" id="name" placeholder="Enter designated name for type of evacuation">
				    	</div>
				  	</div>
				  	<div class="form-group">
					  	<label class="control-label col-sm-2" for="definition">Definition:</label>
					  	<div class="col-sm-10"> 
							<textarea class="form-control" rows="5" id="definition" placeholder="Enter its terms and definition"></textarea>
						</div>
					</div>

				  	<div class="form-group"> 
				    	<div class="col-sm-offset-2 col-sm-10">
				      		<button type="button" class="btn btn-primary submit">Submit</button>
				    	</div>
				  	</div>
				</form>
				</div>
			</div>
			</div>
		</div>
	</div>
	<div id="apply" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <h1 class="modal-title"></span>Successful</h1>
		      </div>
		      <div class="modal-body">
		      	<p>Successfully Created a new type of Evacuation Center!</p>
		      </div>
		      <div class="modal-footer">
			      <input type="button" id="closer" name="submit" class="btn btn-primary" value="Close" />
			   </div>
		    </div>
		  </div>
	</div>
	<!-- The Footer -->
	<?php $cswd->footer(); ?>
	<script type="text/javascript">

		$(document).on("click", ".submit", function() { 
				var name = document.getElementById('name').value;
				var definition = document.getElementById('definition').value;
				
				$.ajax({type:"POST",url:"ajax.php",
					data: {
						name:name,
						definition:definition,
						action:"create_evacuation_type"
					},
				    }).then(function(data) {
				    	$('#apply').modal('show');
				    });
			});
		$(document).on("click", "#closer", function() { $('#apply').modal('hide'); location.reload();});
	</script>
</body>
</html>