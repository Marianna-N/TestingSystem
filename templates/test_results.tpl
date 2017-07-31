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
	<h2>Hello, user! You passed the {DV="test_name"}!</h2>
			{DV="test_results"}
	<div id="results">
		<p>Correct answers: {DV="correct_answers"}</p>
		<p>Incorrect answers:{DV="incorrect_answers"} </p>
		<p>Percentage of correct answers:{DV="percentage"}%</p>
	</div>
	</body>
</html>