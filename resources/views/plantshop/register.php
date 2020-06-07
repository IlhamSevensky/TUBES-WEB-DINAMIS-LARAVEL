<?php
	include 'includes/session.php';

	if(isset($_POST['signup'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];

		$_SESSION['firstname'] = $firstname;
		$_SESSION['lastname'] = $lastname;
		$_SESSION['email'] = $email;

		if($password != $repassword){
			$_SESSION['error'] = 'Passwords did not match';
			header('location: signup.php');
		}
		else{
			$conn = $pdo->open();

			$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email=:email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			if($row['numrows'] > 0){
				$_SESSION['error'] = 'Email already taken';
				header('location: signup.php');
			}
			else{
				// Indonesian Time Zone
				$timezone = time() + (60 * 60 * 7);
				$now = gmdate('Y-m-d', $timezone);

				$password = password_hash($password, PASSWORD_DEFAULT);

				//generate code
				// $set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				// $code=substr(str_shuffle($set), 0, 12);
				$type_user = 0;
				$type_admin = 1;
				$status_active = 1;

				try{
					$stmt = $conn->prepare("INSERT INTO users (id, email, password, type, firstname, lastname, status, created_on) VALUES (null, :email, :password, :type, :firstname, :lastname, :status, :now)");
					$stmt->execute(['email'=>$email, 'password'=>$password, 'type'=>$type_user, 'firstname'=>$firstname, 'lastname'=>$lastname,'status'=>$status_active , 'now'=>$now]);
					$userid = $conn->lastInsertId();

				        $_SESSION['success'] = 'Account succesfully created.';
				        header('location: login.php');

				}
				catch(PDOException $e){
					$_SESSION['error'] = $e->getMessage();
					header('location: signup.php');
				}

				$pdo->close();

			}

		
		}
	}
	else{
		$_SESSION['error'] = 'Fill up signup form first';
		header('location: signup.php');
	}

?>