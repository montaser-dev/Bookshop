<?php

include 'config.php';

if(isset($_POST['submit'])){

	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = mysqli_real_escape_string($conn, md5($_POST['password']));
	$cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
	$user_type = $_POST['user_type'];

	$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

	if(mysqli_num_rows($select_users) > 0){
		echo "<script> alert ('user already exist!')</script>";
		header('location:register.php');
	}else{
		if($pass != $cpass){
			echo "<script>alert ('confirm password not matched!')</script>";
			header('location:register.php');
		}else{
			mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
			echo "<script>alert ('registered successfully!')</script>";
			header('location:login.php');
		}
	}

}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="userForm.css?v=<?php echo time(); ?>">

	<title>Register</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/icons/bookstore.png">
</head>
<body >

	<div class="container">
		<form action="" method="POST" class="login-email" name="form">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="name" value="" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="" required>
			</div>

			<div class="input-group">
			<select name="user_type" class="input-group">
			<option value="user">user</option>
			<option value="admin">admin</option>
		    </select>
			</div>

			<div class="input-group">
				<button name="submit" class="btn" onclick="ValidateEmail(document.form.email)">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="login.php">Login Here</a>.</p>
		</form>
	</div>
	<script src="register.js"></script>
</body>
</html>