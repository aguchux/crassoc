<?php
	
	$Name = addslashes($_POST['Name']);
	$Email = addslashes($_POST['Email']);
	$Phone = addslashes($_POST['Phone']);
	$Description = addslashes($_POST['Description']);
	
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <info@crassociatefinance.com>' . "\r\n";

	$subject = "NewContact@CRAssoFin.com";
	
	$message = "
		<html>
			<head>
				<title>Email From: <strong>{$Email}</strong></title>
			</head>
		<body>
			<p>Email From: <strong>{$Email}</strong></p>
			<table>
				<tr>
					<th>Full Name</th>
					<th>Email</th>
					<th>Phone Number</th>
				</tr>
				<tr>
					<td>{$Name}</td>
					<td>{$Email}</td>
					<td>{$Phone}</td>
				</tr>
				<tr>
					<td colspan=\"3\">
					<p><strong>Details</strong><hr/></p>
					{$Description}
					</td>
				</tr>
			</table>
		</body>
		</html>
	";
	$sent = (int)mail("info@crassociatefinance.com",$subject,$message,$headers);
	if($sent){
		header("Location: ./contact-us/sent/");
	}else{
		header("Location: ./contact-us/unsent/");
	}
	
?>