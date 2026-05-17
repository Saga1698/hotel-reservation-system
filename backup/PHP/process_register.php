<?php
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	

	// Database connection
	$conn = new mysqli('localhost','root','','hotel');

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT * FROM registered_user";
	$result = $conn->query($sql);

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = $_POST["username"];
		$password = $_POST["password"];
		$email = $_POST["email"];
		
		if ($result->num_rows > 0) {
			$xmlFile = 'user.xml';
			$xml = new SimpleXMLElement('<root></root>');
			while ($row = $result->fetch_assoc()) {
				$item = $xml->addChild('item');
				$item->addChild('username', $row['username']);
				$item->addChild('password', $row['password']);
				$item->addChild('email', $row['email']);
			}
			
			$row = array(
				'username' => $username,
				'password' => $password,
				'email' => $email,
			);

			$item = $xml->addChild('item');
    		foreach ($row as $key => $value) {
        		$item->addChild($key, $value);
    		}
			$xmlFile = 'user.xml';
			if ($xml->asXML($xmlFile)) {
				echo "XML file created successfully.";
			} else {
				echo "Error creating XML file.";
			}
		} else {
			echo "No records found.";
		}
	
		$stmt = $conn->prepare("insert into registered_user(username, password, email) values(?, ?, ?)");
		$stmt->bind_param("sss", $username, $password, $email,);
		$execval = $stmt->execute();
	
	
		if ($conn -> query($sql) == TRUE) {
			echo "<script>alert('Registration Successfully.');
			     window.location.href='../HTML/login.php';</script>";
		}
		else {
			echo "Error:" . $sql. "<br>" .$conn -> error;
		}
	}
	$conn->close();

?>