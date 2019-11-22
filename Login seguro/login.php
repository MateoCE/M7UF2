<?php
			session_start();
			include 'conn.php';	
			
			$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			
			$email = $_POST['email']; 
			$password = hash('sha256',$_POST['password']);
			//echo $password;

			$consulta ="SELECT email, password, name FROM user WHERE email = '$email'";
			$result = mysqli_query($conn, $consulta);

			$row = mysqli_fetch_assoc($result);

			$hash = $row['password'];
			
			if ($password ==$hash) {	
				
				$_SESSION['loggedin'] = true;
				$_SESSION['name'] = $row['name'];
				$_SESSION['start'] = time();
				$_SESSION['expire'] = $_SESSION['start'] + (1 * 60) ;						
				
				echo "<div class='alert alert-success mt-4' role='alert'><strong>Welcome!</strong> ".$row['name']."			
				</div>";	
			
			} else {
				echo "<div class='alert alert-danger mt-4' role='alert'>Email or Password are incorrects!
				<p><a href='login.html'><strong>Please try again!</strong></a></p></div>";			
			}	
?>
