<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){
   //function escapes special characters in a string for use in an SQL query, taking into account the current character set of the connection.
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = mysqli_real_escape_string($conn, md5($_POST['password']));

	$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

	if(mysqli_num_rows($select_users) > 0){
		$row = mysqli_fetch_assoc($select_users);

		if($row['user_type'] == 'admin'){

			$_SESSION['admin_name'] = $row['name'];
			$_SESSION['admin_email'] = $row['email'];
			$_SESSION['admin_id'] = $row['id'];
			header('location:admin_page.php');

		}elseif($row['user_type'] == 'user'){

			$_SESSION['user_name'] = $row['name'];
			$_SESSION['user_email'] = $row['email'];
			$_SESSION['user_id'] = $row['id'];
			header('location:home.php');

		}

	}else{
		$message[] = 'incorrect email or password !';
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- font awesome cdn link  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

	<link rel="stylesheet" type="text/css" href="userForm.css?v=<?php echo time(); ?>">
	<!-- <link rel="stylesheet" href="css/style.css"> -->

	<title>Login</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/icons/bookstore.png">
</head>
<body>

<?php
if(isset($message)){
	foreach($message as $message){
		echo "
        <script>
		alert('incorrect email or password !');
		</script>
		";
	}
}
?>
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>
			<p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
		</form>
	</div>
</body>
</html>