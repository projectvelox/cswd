<?php 
	include('session.php');
	$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
	if($_POST["action"]=="change_evacuation") {
		$evacuation = $_POST['evacuation'];
		$sql = "SELECT EVACADDRESS1 FROM evacuation_list WHERE EVACNAME = '$evacuation'";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($result);
		if($row['EVACADDRESS1'] != ""){
			echo $row['EVACADDRESS1'];
		}
		else { echo "City Social Welfare and Development Office of Iloilo City";}
	}

	if($_POST["action"]=="change_donation") {
		$donation = $_POST['donation'];
		$sql = "SELECT donation_name FROM cswd_donations_type WHERE donation_name = '$donation'";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($result);
		echo $row['donation_name'];
	}

	if($_POST["action"]=="create_relief_operation"){
		$disaster = $_POST['disaster'];
		$disasterid = $_POST['disasterid'];
		$evacid = $_POST['evacid'];
		$driver = $_POST['driver'];
		$username = $_POST['username'];
		$evacuation = $_POST['evacuation'];
		$packages = $_POST['packages'];
		$address = $_POST['address'];
		$now = date('Y-m-d H:i:s'); 
		$people = $_POST['people'];
		$family = $_POST['family'];
		$male = $_POST['male'];
		$female = $_POST['female'];
		$maleChild = $_POST['maleChild'];
		$femaleChild = $_POST['femaleChild'];
		$maleTeen = $_POST['maleTeen'];
		$femaleTeen = $_POST['femaleTeen'];
		$maleAdult = $_POST['maleAdult'];
		$femaleAdult = $_POST['femaleAdult'];
		$maleSenior = $_POST['maleSenior'];
		$femaleSenior = $_POST['femaleSenior'];
		$pwd = $_POST['pwd'];
		$lat = $_POST['lat'];
		$lng = $_POST['lng'];
		$sql = "INSERT INTO cswd_create_relief(evacid, disasterid, operations, driver, evacuation_center, address, packages, task_created, evacuees, family, male, female, maleChild, femaleChild, maleTeen, femaleTeen, maleAdult, femaleAdult, maleSenior, femaleSenior, pwd, lat, lng) VALUES ('$evacid','$disasterid','$disaster', '$driver', '$evacuation', '$address', '$packages', '$now', '$people', '$family', '$male', '$female', '$maleChild', '$femaleChild', '$maleTeen', '$femaleTeen', '$maleAdult', '$femaleAdult', '$maleSenior', '$femaleSenior', '$pwd' , '$lat' , '$lng')";
		$sql1 = "UPDATE cswd_account SET status='Delivering' WHERE username='$username'";
		$result = mysqli_query($con,$sql);
		$results = mysqli_query($con, $sql1);
	}

	if($_POST["action"]=="create_evacuation_type"){
		$name = $_POST['name'];
		$definition = $_POST['definition'];
		$con = mysqli_connect("localhost","cdrrmodata","cdrrmodata","cdrrmodata");	
		$sql = "INSERT INTO cswd_evacuation_types(name, definition) VALUES ('$name', '$definition')";
		$result = mysqli_query($con,$sql);
	}

	if($_POST["action"]=="create_account"){
		$username = $_POST['username'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$account_type = $_POST['account_type'];
		$sql = "INSERT INTO cswd_account(firstname, lastname, username, password, account_type, status) VALUES ('$firstname', '$lastname', '$username', 'defaultpassword', '$account_type', 'Active')";
		$result = mysqli_query($con,$sql);
	}

	if($_POST["action"]=="create_evacuation_center"){
		$name = $_POST['name'];
		$type = $_POST['type'];
		$barangay = $_POST['barangay'];
		$address = $_POST['address'];
		$capacity = $_POST['capacity'];
		$rooms = $_POST['rooms'];
		$toilets = $_POST['toilets'];
		$now = date('Y-m-d H:i:s'); 
		$sql = "INSERT INTO evacuation_list(BARANGAY, EVACNAME, EVACADDRESS1, CAPACITY, DATEADDED) VALUES ('$barangay', '$name', '$address', '$capacity', '$now')";
		$sql1 = "INSERT INTO cswd_evacuation(evacuation_name, evacuation_type, rooms, toilets) VALUES ('$name', '$type', '$rooms', '$toilets')";
		$result = mysqli_query($con,$sql);
		$results = mysqli_query($con,$sql1);
	}

	if($_POST["action"]=="add_donations"){
		$donor = $_POST['donor'];
		$evacuation_center = $_POST['evacuation'];
		$address = $_POST['address'];
		$donation_type = $_POST['donation'];
		$particulars = $_POST['particulars'];
		$quantity = $_POST['quantity'];
		$unit = $_POST['unit'];
		$now = date('Y-m-d H:i:s'); 	
		$sql = "INSERT INTO cswd_donations(donor_name, evacuation_center, address, donation_type, particulars, quantity, unit, donation_date) VALUES ('$donor', '$evacuation_center', '$address', '$donation_type', '$particulars', '$quantity', '$unit','$now')";
		$result = mysqli_query($con,$sql);
	}

	if($_POST["action"]=="start") {
		$now = date('Y-m-d H:i:s'); 
		$id = $_POST['id'];
		$sql = "UPDATE cswd_create_relief SET delivery_started='$now' WHERE driver='$login_fullname' AND id='$id' AND delivery_started IS NULL ";
		$result = mysqli_query($con,$sql);
	}

	if($_POST["action"]=="end") {
		$now = date('Y-m-d H:i:s');
		$id = $_POST['id']; 
		$sql = "UPDATE cswd_create_relief SET delivery_ended='$now' WHERE driver='$login_fullname' AND id='$id' AND delivery_started IS NOT NULL AND delivery_ended IS NULL";
		$sql1 = "UPDATE cswd_account SET status='Active' WHERE username='$login_session'";
		$result = mysqli_query($con,$sql);
		$results = mysqli_query($con, $sql1);	
	}

	if($_POST["action"]=="remove_evacuation_type") {
		$id = $_POST['id'];
		$sql = "UPDATE cswd_evacuation_types SET status='Removed' WHERE id='$id'";
		$result = mysqli_query($con,$sql);
	}

	if($_POST["action"]=="update_password") {
		$password = $_POST['password'];
		$newpassword = $_POST['newpassword'];
		$reconfirm = $_POST['reconfirm'];
		$sql = "SELECT password FROM accounts where username='$login_session'";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($result);
		if($row['password'] != $password){ echo "Incorrect Password! Please retype your password"; }
		else {
			if($newpassword != $reconfirm){ echo "New password does not match. Retype new password"; }
			else {
				$sql = "UPDATE cswd_account SET password='$newpassword' WHERE username='$login_session'";
				$result = mysqli_query($con,$sql);
				echo "Successfully updated your password!";
			}
		}
	}

	if($_POST["action"]=="shet") {
		$driver = $_POST['driver'];
        $disasterid = $_POST['disasterid'];
		$results = mysqli_query($con,"SELECT DISTINCT EVACID, EVACNAME FROM evacuation_report INNER JOIN evacuation_list ON evacuation_list.ID=evacuation_report.EVACID WHERE evacuation_report.DECLAREID=" . $disasterid . " AND evacuation_list.EVACNAME NOT IN (SELECT evacuation_center FROM cswd_create_relief where driver = '$driver' AND delivery_ended IS NULL) ORDER BY evacuation_report.DATEADDED DESC");
		echo "<option disabled selected>Assign an evacuation center</option>";
		while($row = mysqli_fetch_array($results))
		{
			$evacuation = $row['EVACNAME'];
			echo "<option data-evacuation='".$evacuation."' data-evacid='".$row['EVACID']."'>" . $evacuation .  "</option>";
		}
                 
	}

	if($_POST["action"]=="automatefamily") {
		$evacid = $_POST['evacid'];
		$disasterid = $_POST['disasterid'];
		$sql = "SELECT SRVFAMILIES, SRVPERSONS FROM evacuation_report WHERE DECLAREID='$disasterid' AND EVACID='$evacid' ORDER BY DATEADDED DESC LIMIT 1";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($result);
		echo $row['SRVFAMILIES'].",".$row['SRVPERSONS'];
	}

	if($_POST["action"]=="getstatus") {
		$evacuation = $_POST['evacuation'];
		$disaster = $_POST['disaster'];
		$sql = "SELECT * FROM cswd_evacuation_status WHERE disaster='$disaster' AND evacuation_center='$evacuation' ORDER BY id DESC LIMIT 1";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($result);
		if(empty($row['evacuation_center'])){
			echo "Null";
		}
		else{ echo $row['evacuation_center'].",".$row['unservedfamilies'];}
	}

	if($_POST["action"]=="status_ec") {

		$id = $_POST['id'];
		$disaster = $_POST['disaster'];
		$evacuation_center = $_POST['evacuation_center'];
		$familiesserved = $_POST['familiesserved'];
		$remainingpackages= $_POST['remainingpackages'];
		$unservedfamilies= $_POST['unservedfamilies'];
		$results = mysqli_query($con,"INSERT INTO cswd_evacuation_status(disaster, evacuation_center, familiesserved, remainingpackages, unservedfamilies) VALUES ('$disaster','$evacuation_center', '$familiesserved', '$remainingpackages', '$unservedfamilies')");
		$result = mysqli_query($con, "UPDATE cswd_create_relief SET status='Complete' WHERE id='$id'");

	}

	if($_POST["action"]=="post_rehab") {

		$relatives = $_POST['relatives'];
		$house = $_POST['house'];
		$home = $_POST['home'];
		$stayers = $_POST['stayers'];
		$evacuation_center = $_POST['evacuation_center'];
		$disaster = $_POST['disaster'];			
		$results = mysqli_query($con,"INSERT INTO cswd_post_rehabilitation(relatives, house, home, stayers, evacuation_center, disaster) VALUES ('$relatives', '$house', '$home', '$stayers', '$evacuation_center', '$disaster')");
	}


	if($_POST["action"]=="latlng") {
		$evacuation = $_POST['evacuation'];
		$sql = "SELECT lat, lng FROM cswd_evacuation_listing WHERE name = '$evacuation'";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($result);
		echo $row['lat'] . "," . $row['lng'];
	}

	if($_POST["action"]=="HolyShitHopeThisWorks") {
		$evacuation = $_POST['evacuation'];
		$barangay = mysqli_query($con, "SELECT barangay_name FROM cswd_evacuation_listing WHERE name = '$evacuation'");
		$row=mysqli_fetch_assoc($barangay);
		$brgy = $row['barangay_name'];

		//Barangay DB
		$otherconnect = mysqli_connect("localhost","cdrrmodata","cdrrmodata","brgyjarodbnew");	
		//Child
		$maleChild = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE age >= 0 AND age <= 12 AND brgy='$brgy' AND sex='Male'");
		$femaleChild = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE age >= 0 AND age <= 12 AND brgy='$brgy' AND sex='Female'");
		$childMale=mysqli_fetch_assoc($maleChild);
		$childFemale=mysqli_fetch_assoc($femaleChild);

		//Teen
		$maleTeen = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE age >= 13 AND age <= 19 AND brgy='$brgy' AND sex='Male'");
		$femaleTeen = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE age >= 13 AND age <= 19 AND brgy='$brgy' AND sex='Female'");
		$teenMale=mysqli_fetch_assoc($maleTeen);
		$teenFemale=mysqli_fetch_assoc($femaleTeen);

		//Adult
		$maleAdult = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE age >= 20 AND age <= 59 AND brgy='$brgy' AND sex='Male'");
		$femaleAdult = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE age >= 20 AND age <= 59 AND brgy='$brgy' AND sex='Female'");
		$adultMale=mysqli_fetch_assoc($maleAdult);
		$adultFemale=mysqli_fetch_assoc($femaleAdult);

		//Senior
		$maleSenior = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE age >= 60 AND age <= 200 AND brgy='$brgy' AND sex='Male'");
		$femaleSenior = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE age >= 60 AND age <= 200 AND brgy='$brgy' AND sex='Female'");
		$seniorMale=mysqli_fetch_assoc($maleSenior);
		$seniorFemale=mysqli_fetch_assoc($femaleSenior);

		//All
		$maleAll = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE brgy='$brgy' AND sex='Male'");
		$femaleAll = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswdbarangay WHERE brgy='$brgy' AND sex='Female'");
		$allMale=mysqli_fetch_assoc($maleAll);
		$allFemale=mysqli_fetch_assoc($femaleAll);

		//Disabled
		$disabled = mysqli_query($otherconnect, "SELECT COUNT(*) AS output FROM cswddisable WHERE brgy='$brgy'");
		$disableRow = mysqli_fetch_assoc($disabled);

		$child = $childMale['output'] . "," . $childFemale['output'];
		$teen = $teenMale['output'] . "," . $teenFemale['output'];
		$adult = $adultMale['output'] . "," . $adultFemale['output'];
		$senior = $seniorMale['output'] . "," . $seniorFemale['output'];
		$all = $allMale['output'] . "," . $allFemale['output'];
		$disable = $disableRow['output']; 
		echo $child . "," . $teen . "," . $adult . "," . $senior . "," . $all . "," . $disable;

	}

?>
