var inputs_pic = 1;
var inputs_answ = 2;
function addPicture()
{
	//alert("addPicture");
	var div = document.createElement("div");
	var addImg = (inputs_pic++>0)?'<img src="images/minus.png" onclick="removeDiv(this)"/>':'';
	div.innerHTML = addImg+'<input type="file" name="picture'+inputs_pic+'">';
	document.getElementById("picture_block").appendChild(div);
}

function addAnswer()
{
	//alert("addAnswer");
	var div = document.createElement("div");
	var addImg = (inputs_answ++>0)?'<img src="images/minus.png" onclick="removeDiv(this)"/>':'';
	div.innerHTML = addImg+'<span>(correct </span><input type="radio" name="radio-answer" value="answer'+inputs_answ+'"><span>)</span><input type="text" name="answer'+inputs_answ+'" id="answer'+inputs_answ+'" size="40" maxlength="40"/>';
	document.getElementById("answer_block").appendChild(div);
}

function removeDiv(img)
{
	img.parentNode.remove();
}

