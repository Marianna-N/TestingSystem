<!DOCTYPE html>
<html>
	<head>
		<title>Testing System</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/reset.css"/>
		<link rel="stylesheet" href="styles/style03.css"/>
	</head>
	<body>
	<h2>Hello, admin! You did it!!!</h2>
	<a href="?logout=go" class="link_button" id="logout">Logout</a>
	<div id="creation_choose">
		<div id="creation">
		<h4 class="title">Create</h4>
		<a href="?create_test=go" class="link_button" target="_blank">&nbspTest&nbsp</a>
		<a href="?create_question=go" class="link_button" target="_blank">Question</a>
		</div>
		<div id="choose_statistics">
		<h4 class="title">Show statistics</h4>
		<a href="?user_statistic=go" class="link_button" target="_blank">User statistics</a>
		<a href="?test_statistic=go" class="link_button" target="_blank">Test statistics</a>
		</div>
	</div>
	<hr>
	<br>
	<p id="generate_key">{DV="generate_key"}</p>
	<a href="?generate_key=go" class="link_button" id="generate_btn">Generate key</a>
	<br>
	<br>
	<hr>
	<p class="title">Assign permissions</p>
	<p class="error_message">{DV="error_permissions"}</p>
	<form action = "index.php" method = "POST">
		<label for="p_user">User:</label>
			<input type="text" name="p_user" id="p_user" size="40" maxlength="40">
		<label for="permissions">Permissions:</label>
			<input type="text" name="permissions" id="permissions" size="20" maxlength="20">
			<input type="submit" value="Assign" class="button">
	</form>
	<hr>
	<p class="title">Assign test</p>
	<p class="error_message">{DV="error_assign_test"}</p>
	<form action = "index.php" method = "POST">
		<label for="test_user">User or key:</label>
			<input type="text" name="test_user" id="test_user" size="40" maxlength="40">
		<label for="test">Test:</label>
			<input type="text" name="test" id="test" size="20" maxlength="20">
			<input type="submit" value="Assign" class="button">
	</form>
	<hr>
	<p class="title">Tests</p>
	<div id="all_tests">{DV="all_tests"}</div>
	</body>
</html>