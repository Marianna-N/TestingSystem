<!DOCTYPE html>
<html>
	<head>
		<title>Testing System</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/reset.css"/>
		<link rel="stylesheet" href="styles/style04.css"/>
		<link rel="stylesheet" href="styles/style06.css"/>
		<script type="text/javascript" src="js/create_question.js"></script>
	</head>
	<body>
	<h2>Hello, user! Pass a {DV="test_name"}!</h2>
	<form action="index.php" method="POST" enctype="multipart/form-data" id="test_form">
			{DV="test_questions"}
			<input type="submit" name="pass_test" value="Get Results!" class="button" >
	</form>
	</body>
</html>