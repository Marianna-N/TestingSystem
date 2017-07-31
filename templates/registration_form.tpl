<!DOCTYPE html>
<html>
	<head>
		<title>Testing System</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/reset.css"/>
		<link rel="stylesheet" href="styles/style01.css"/>
		<link rel="stylesheet" href="styles/style02.css"/>
		<script type="text/javascript" src="js/validate_registration.js"></script>
	</head>
	<body>
	<div id="form_registration">
		<h2>REGISTRATION</h2>
		<p class="error_message" id="error_register">{DV="error_register"}</p>
		<form id="registrationBlock"  method = "POST" onsubmit="return validate(this);">
		<label for="new_login">Login:</label></br>
			<input type="text" name="new_login" id="new_login" size="30" maxlength="30"></br>
		<label for="password_1">Password:</label></br>
			<input type="password" name="password_1" id="password_1" size="30" maxlength="30"></br>
		<label for="password2">Repeat password:</label></br>
			<input type="password" name="password_2" id="password_2" size="30" maxlength="30"></br>
		<label for="name">Name:</label></br>
			<input type="text" name="name" id="name" size="40" maxlength="40"></br>		
		<label for="lastname">Lastname:</label></br>
			<input type="text" name="lastname" id="lastname" size="40" maxlength="40"></br>	
		<label for="training">Training:</label></br>
			<input type="text" name="training" id="training" size="40" maxlength="40"></br>	
		<label for="email">E-mail:</label></br>
			<input type="email" name="email" id="email" size="40" maxlength="40"></br>				
			<input type="submit" value="Register" class="button"><br>
		</form>
		
	</div>
	</body>
</html>