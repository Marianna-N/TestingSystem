<!DOCTYPE html>
<html>
	<head>
		<title>Testing System</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles/reset.css"/>
		<link rel="stylesheet" href="styles/style04.css"/>
		<script type="text/javascript" src="js/create_question.js"></script>
	</head>
	<body>
	<h2>{DV="statistics_name"}</h2>
		<table border="1" id="table">
		<thead>
			<tr>
			<th>{DV="header_1"}</th><th>{DV="header_2"}</th><th>{DV="header_3"}</th><th>{DV="header_4"}</th><th>{DV="header_5"}</th>
			</tr>
		</thead>
		<tbody>
			{DV="statistics"}
		</tbody>
		</table>
	</body>
</html>