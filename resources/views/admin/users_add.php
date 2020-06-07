<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$address = $_POST['address'];
		$contact = $_POST['contact'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email already taken';
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$filename = $_FILES['photo']['name'];
			// Indonesian Time Zone
			$timezone = time() + (60 * 60 * 7);
			$now = gmdate('Y-m-d', $timezone);
			$type_user = 0;
			$type_admin = 1;
			$status_active = 1;

			if(!empty($filename)){
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
			}
			try{
				$stmt = $conn->prepare("INSERT INTO users (id, email, password, type, firstname, lastname, photo , status, created_on) VALUES (null, :email, :password, :type, :firstname, :lastname, :photo, :status, :now)");
				$stmt->execute(['email'=>$email, 'password'=>$password, 'type'=>$type_user, 'firstname'=>$firstname, 'lastname'=>$lastname, 'photo'=>$filename, 'status'=>$status_active , 'now'=>$now]);
				$_SESSION['success'] = 'User added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up user form first';
	}

	header('location: users.php');

?>