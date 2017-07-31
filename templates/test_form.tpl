<!DOCTYPE html>
<html>
	<head>
		<title>Testing System</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/reset.css"/>
		<link rel="stylesheet" href="styles/style04.css"/>
		<link rel="stylesheet" href="styles/style05.css"/>
		<script type="text/javascript" src="js/create_question.js"></script>
	</head>
	<body>
	<h2>Hello, admin! Create a test</h2>
	<form action="index.php" method="POST" enctype="multipart/form-data" id="test_form">
			<label for="test_name">Test name:</label></br>
			<input type="text" name="test_name" id="test_name" size="20" maxlength="20"></br>
			{DV="created_questions"}
			<input type="submit" name="upload_test" value="Create" class="button" >
	</form>
	</body>
</html>