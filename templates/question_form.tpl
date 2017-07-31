<!DOCTYPE html>
<html>
	<head>
		<title>Testing System</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/reset.css"/>
		<link rel="stylesheet" href="styles/style04.css"/>
		<link rel="stylesheet" href="styles/style07.css"/>
		<script type="text/javascript" src="js/create_question.js"></script>
	</head>
	<body>
	<h2>Hello, admin! Create a question</h2>
	<form action="index.php" method="POST" enctype="multipart/form-data" id="question_type1" onsubmit="">
			<h3>Question:</h3>
			<textarea name="question" cols="50" rows="5"></textarea>
			<div id="picture_block">
			<h3>Upload picture:</h3>
			<a href="#" onclick = "addPicture();">Add picture</a>
			<br>
			<input type="file" name="picture1">
			</div>
			<div id="answer_block">
			<h3>Answers:</h3>
			<a href="#" onclick = "addAnswer();">Add answer</a>
			<br>
			<span>(correct </span><input type="radio" name="radio-answer" value="answer1" checked><span>)</span>
			<input type="text" name="answer1" id="answer1" size="40" maxlength="40"/>
			<br>
			<span>(correct </span><input type="radio" name="radio-answer" value="answer2"><span>)</span>
			<input type="text" name="answer2" id="answer2" size="40" maxlength="40"/>
			</div>
			<input type="submit" name="upload" value="Create" class="button" >
	</form>
	</body>
</html>