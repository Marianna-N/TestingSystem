<!DOCTYPE html>
<html>
	<head>
		<title>Testing System</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/reset.css"/>
		<link rel="stylesheet" href="styles/style01.css"/>
	</head>
	<body>
	<div id="form_login">
		<h2>LOGIN</h2>
		<p class="error_message" id="error_login">{DV="error_login"}</p>
		<form action = "index.php" method = "POST">
		<label for="login">Login:</label></br>
			<input type="text" name="login" id="login" size="40" maxlength="40"></br>
		<label for="password">Password:</label></br>
			<input type="password" name="password" id="password" size="40" maxlength="40"></br>
			<input type="submit" value="Login" class="button"><br>
			<input type="checkbox" name="remember" id="checkbox"><p id="label_remember">Remember me</p>
		</form>
		<p id="link_registration">If you don't have account, please, register <a href="index.php?registration=new">here</a></p>
	</div>
	<div id="form_key">
		<h2>ENTRANCE WITH SPECIAL KEY</h2>
		<p class="error_message" id="error_key">{DV="error_key"}</p>
		<form action = "index.php" method = "POST">
		<label for="key">Key:</label></br>
			<input type="text" name="key" id="key" size="40" maxlength="40"><br>
			<input type="submit" value="Start testing" class="button"><br>
		</form>		
	</div>
	</body>
</html>