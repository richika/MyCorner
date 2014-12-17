<?php
	require_once('load.php');
	$log->register();
?>

<html>
	<head>
		<title>TheNetwork Registration</title>
		<style type="text/css">
			body { background:#A3527A;}
		</style>
	</head>

	<body>
    
    <div id='header'>
     <h1>TheNetwork</h1>
     </div>
		<div id='main' style="width: 960px; background: #FFE1F1; border: 1px solid #e4e4e4; padding: 20px; margin: 10px auto;">
			<h3>Register Here!</h3>
            
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<table>
					<tr>
						<td>Name:</td>
						<td><input type="text" name="name" /></td>
					</tr>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="pass" /></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" name="email" /></td>
					</tr>
                    <tr>
                        <td>Date of birth:</td>
                        <td><input type="date" name="dob" /></td>
                        </tr>
                    <tr>
                        <td>Location:</td>
                        <td><input type="text" name="location" /></td>
                     </tr>
                     <tr>
                         <td>Phone number:</td>
                         <td><input type="text" name="phone_no" /></td>
                         </tr>
               
					<input type="hidden" name="time" value="<?php echo time(); ?>" />
					<tr>
						<td></td>
						<td><input type="submit" value="Register!" /></td>
					</tr>
				</table>
			</form>
			<p>Already a member? <a href="login.php">Log in here!</a></p>
		</div>
	</body>
</html>