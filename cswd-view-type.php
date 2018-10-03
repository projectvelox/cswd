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
<head><?php $cswd->frontHead(); ?></head>
<body>
	<div id="addNew" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Add Evacuation Type</h4>
	      </div>
	      <div class="modal-body">
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
		      </div>
		      <div class="modal-footer">
		      <button class="btn btn-primary btn-sm submit">Submit</button>
		      </div>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
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
			  <li><a href="cswd-manage-evacuation.php">Manage Evacuation Centers</a></li>
     		  <li class="active"><span>Evacuation Type List</span></li>
			</ol>
				<div class="cswd-header">
					<h1 style="margin-bottom: -15px;">Evacuation Type List</h1>
					<div class="text-right">
						<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addNew">Add Type <span class="glyphicon glyphicon-plus"></span></button>
					</div>
				</div>
				<div class="cswd-content-container" style="padding-bottom: 0px">
					<form class="form-horizontal" action="cswd-view-type.php" method="POST">
					    <div class="form-group">
					        <div class="input-group">
							  <input type="text" class="form-control" id="evacuation" name="evacuation" placeholder="Search Evacuation Type">
							  <span class="input-group-btn">
							    <button class="btn btn-default" type="submit">Search</button>
							  </span>
							</div>
						</div>
					</form>
				</div>
				<div class="col-sm-12 col-md-12">
    			<div class="table-responsive">
					<table class="table table-hover">
					  	<tr>
					  		<th>#</th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Name" href="cswd-view-type.php?name=name ASC">Name</a></th>
					  		<th><a data-toggle="tooltip" data-placement="bottom" title="Order by Definition" href="cswd-view-type.php?name=definition ASC">Definition</th>
					  		<th>Status</th>
					  	</tr>
					  	<?php
					  		$i=0;
					  		$x = $_GET['name'];
					  		if($x=='') { $x='id';}
					  		$evacuation = $_POST['evacuation'];

							$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");
							$result = mysqli_query($con,"SELECT * FROM cswd_evacuation_types WHERE (name LIKE '%".$evacuation."%' OR (definition LIKE '%".$evacuation."%')) AND status='Active' ORDER BY ".mysqli_real_escape_string($con, $x)."");
								while($row = mysqli_fetch_array($result))
								{
									$i++;
									echo "<tr>";
									echo "<td>" . $i . " </td>";
									echo "<td>" . $row['name'] . " </td>";
									echo "<td>" . $row['definition'] . "</td>";
									if($row['status']=='Active') { echo "<td><button data-id='".$row['id']."' class='btn btn-danger btn-sm remove'>Remove</button></td>";}
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
	<script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip(); 
	});
	$(document).on("click", ".remove", function() { 
		var id = $(this).data('id')
		
		$.ajax({type:"POST",url:"ajax.php",
			data: {
				id:id,
				action:"remove_evacuation_type"
			},
		    }).then(function(data) {
		    	location.reload();
		    });
	});
	</script>
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