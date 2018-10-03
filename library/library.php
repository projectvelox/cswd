<?php 
  	class cswd
	{
		/* This is for the index */
		function footer(){
			$html =  '';
			$html .= '
			    <div class="footer-bottom">
			        <div class="container">
			        	<hr>
			            <p class="text-center"> Copyright © Velox Solutions 2017. All right reserved. </p>
			        </div>
			    </div>
			<script src="js/jquery-3.1.1.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			';

			echo $html;
		}

		function navbar() {
			$html =  '';
			$html .= '
			<nav class="navbar navbar-inverse navbar-fixed-top"> 
			  <div class="container">
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="index.php">CSWD</a>
			    </div>
			    <div id="navbar"  class="navbar-collapse collapse navbar-right">
			      	<ul class="nav navbar-nav">
				        <li><a href="cswd-relief.php"><span class="glyphicon glyphicon-bookmark"></span> Relief Operations</a></li>
				        <li><a href="cswd-evacuation.php"><span class="glyphicon glyphicon-home"></span> Evacuation Center</a></li>
				        <li><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			        </ul>
			    </div>
			  </div>
			</nav>';
			echo $html;
		}

		function modal() {
			$html = '';
			$html .= '
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><span class="glyphicon glyphicon-log-in"></span> Login</h4>
			      </div>
			      <div class="modal-body">
			      	<form action="login.php" method="post">
				        <p style="color: #8c8c8c;"><small>Note: Only the admin can register, and reset the password of an account.</small></p>
				        <div class="input-group">
				          <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span> </span>
				          <input type="text" id="username" class="form-control" name="username" placeholder="Username" required />
				        </div><br>
				        <div class="input-group">
				          <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span> </span>
				          <input type="password" id="password" class="form-control" name="password" placeholder="Password" required />
				          <a href="#" style="color: #3c3c3c;" class="input-group-addon">Show</a>
				        </div>
				      </div>
				      <div class="modal-footer">
				        <input type="submit" id="login_form_submit_btn" name="submit" data-loading-text="Logging in..." class="btn btn-primary" value="Login" onclick="retrieveAccount()"/>
			        </form>
			      </div>
			    </div>
			  </div>
			</div>';
			echo $html;
		}
		function carousel() {
			$html = '';
			$html .= '
			<div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">

			  <ol class="carousel-indicators">
			    <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
			    <li data-target="#bs-carousel" data-slide-to="1"></li>
			  </ol>
			  
			  <div class="carousel-inner">
			    <div class="item slides active">
			      <!-- Overlay -->
			  	  <div class="overlay"></div>
			      <div class="slide-1"></div>
			      <div class="hero">
			        <hgroup>
			            <h1>Social Welfare and Development</h1>        
			            <h3>A web-based solution for the City Social Welfare and Development Office of Iloilo City</h3>
			        </hgroup>
			      </div>
			    </div>

			    <div class="item slides">
			      <div class="overlay"></div>
			      <div class="slide-2"></div>
			      <div class="hero">        
			        <hgroup>
			            <h1>Social Welfare and Development</h1>        
			            <h3>A web-based solution for the City Social Welfare and Development Office of Iloilo City</h3>
			        </hgroup>       
			      </div>
			    </div>
			  </div> 
			</div>';
			echo $html;
		}
		function frontSearch() {
			$html = '';
			$html .= '
			<div class="jumbotron" style="padding: 20px 50px;">
				<div class="row">
		           <div id="custom-search-input">
		                <div class="input-group col-md-12">
		                    <input type="text" class="search-query form-control" placeholder="Search CSWD" />
		                    <span class="input-group-btn">
		                        <button class="btn btn-danger" type="button">
		                            <span class=" glyphicon glyphicon-search"></span>
		                        </button>
		                    </span>
		                </div>
		            </div>
		            <div class="cswd-row">
		            	<p>Social Welfare and Development is the official website of the City Social Welfare and Development Office of Iloilo.<br>This website keeps track of Relief Operations and Evacuation Centers in the City of Iloilo</p>
		            </div>
				</div>
			</div>';
			echo $html;
		}
		function frontContent() {
			$html = '';
			$html .= '
			<div class="container">
				<div class="row cswd-status-container">
					<div class="col-md-6">
						<section>
							<h4><i class="glyphicon glyphicon-home"></i> Evacuation Center</h4>
							<ul>
								<li><a href="cswd-evacuation.php" target="_blank" rel="bookmark">Mohon Terminal at Barangay Mohon</a></li>
								<li><a href="cswd-evacuation.php" rel="bookmark">Ortiz Gym at Barangay Ortiz</a></li>
								<li><a href="cswd-evacuation.php" rel="bookmark">West Visayas State University at Montinola</a></li>
								<li><a href="cswd-evacuation.php" rel="bookmark">Central Philippine University at San Isidro</a></li>
								<li><a href="cswd-evacuation.php" rel="bookmark">Saint Joseph Worker Parish Church at San Isidro</a></li>
							</ul>
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
			</div>';
			echo $html;
		}
		
		function frontHead() {
			$html = '';
			$html .= '
			<meta name="description" content="Social Welfare and Development is the official website of the City Social Welfare and Development Office of Iloilo. This website keeps track of Relief Operations and Evacuation Centers in the City of Iloilo"/>
			<meta name="twitter:card" value="summary"/>
			<meta property="fb:app_id" content="129726550914924"/>
			<meta property="og:title" content="Social Welfare and Development"/>
			<meta property="og:type" content="article" />
			<meta property="og:url" content="http://velox-solution.com/cswd/"/>
			<meta property="og:image" content="http://velox-solution.com/cswd/images/logo.png"/>
			<meta property="og:description" content="Social Welfare and Development is the official website of the City Social Welfare and Development Office of Iloilo. This website keeps track of Relief Operations and Evacuation Centers in the City of Iloilo"/>
			<meta charset="utf-8"/>
			<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
			<meta name="viewport" content="width=device-width, initial-scale=1"/>
			<title>Social Welfare and Development</title>
			<link rel="stylesheet" href="css/bootstrap.min.css"/>
			<link rel="stylesheet" href="css/carousel.css"/>
			<link rel="stylesheet" href="css/front-design.css"/>
			<link rel="stylesheet" href="css/style.css"/>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"/>
			<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"/> 
			<link rel="icon" href="images/logo.png" type="image/x-icon"/>
			<script src="js/donut/raphael-min.js"></script>
			<script src="js/jquery-3.1.1.min.js">"></script>
			<script src="js/donut/morris-0.4.1.min.js"></script>';
			echo $html;
		}

		/* Evacuation Center - Non Users */
		function evacuationCenter() {
			$html = '';
			$html .= '
			<div class="container cswd-container">
				<div class="row">
					<div class="cswd-header">
						<h1>Evacuation Centers</h1>
					</div>
					<div class="cswd-content-container">
						<div class="col-md-6 col-xs-12">
							<div id="evacuationCenter">
								<h3>Arevalo</h3>
								<ul class="list-group">
								  <li class="list-group-item">Mohon Terminal - Barangay Mohon</li>
								</ul>
							</div>
							<div id="evacuationCenter">
								<h3>City Proper</h3>
								<ul class="list-group">
								  <li class="list-group-item">Ortiz Gym - Barangay Ortiz</li>
								</ul>
							</div>
							<div id="evacuationCenter">
								<h3>Jaro</h3>
								<ul class="list-group">
								  <li class="list-group-item">West Visayas State University - Barangay Montinola</li>
								  <li class="list-group-item">Central Philippines University - Barangay San Isidro</li>
								  <li class="list-group-item">Saint Joseph Worker Parish Church - Barangay San Isidro</li>
								</ul>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<h3>Info</h3>
							<ul class="list-group">
								<li class="list-group-item"><b>Number of Districts</b><span class="badge">3</span></li>
								<li class="list-group-item"><b>Number of Evacuation Centers</b><span class="badge">5</span></li>	
							</ul>
							<h3>Evacuation Centers per District:</h3>
							<div id="donut-example" style="width: 19em !important; margin: 0px auto;">
							</div>
						</div>
					</div>
				</div>
			</div>';
			echo $html;
		}

		function reliefOperation() {
			$html ='';
			$html .= '
				<div class="container cswd-container">
					<div class="row">
						<div class="cswd-header">
							<h1>Relief Operations</h1>
						</div>
						<div class="cswd-content-container">
							<div class="col-md-6 col-xs-12">
								<div id="evacuationCenter">
									<h3>2017</h3>
									<ul class="list-group">
									  <li class="list-group-item">Operation Frank</li>
									</ul>
								</div>
								<div id="evacuationCenter">
									<h3>2016</h3>
									<ul class="list-group">
									  <li class="list-group-item">Operation Yolanda</span></li>
									</ul>
								</div>
								<div id="evacuationCenter">
									<h3>2015</h3>
									<ul class="list-group">
									  <li class="list-group-item">Operaion Ruby</li>
									  <li class="list-group-item">Operation Fire Storm</li>
									  <li class="list-group-item">Operation Earth Shaker</li>
									</ul>
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<h3>Info</h3>
								<ul class="list-group">
									<li class="list-group-item"><b>Number of Relief Operations This Year</b><span class="badge">1</span></li>
									<li class="list-group-item"><b>Number of Relief Operations In Total</b><span class="badge">5</span></li>	
								</ul>
								<h3>Relief Operations Per Year:</h3>
								<div id="donut-example" style="width: 19em !important; margin: 0px auto;">
								</div>
							</div>
						</div>
					</div>
				</div>';
			echo $html;
		}

	}
?>