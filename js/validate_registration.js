function validate(form){
	x = document.getElementById("registrationBlock").getElementsByTagName("span");
	for (var i=x.length-1; i>=0; i--){
		x[i].parentNode.removeChild(x[i]);
		//console.log(i)
	}

	var name = isFullText(form.name);
	var lastname = isFullText(form.lastname);
	var login = isCorrectLogin(form.new_login);
	var pass1 = isCorrectPass1(form.password_1);
	var pass1pass2 = isCorrectPass1Pass2(form.password_1,form.password_2);
	var email = isCorrectMail(form.email);

	//return false;
	return name && lastname && login && pass1 && pass1pass2 && email;
}

function isFullText(text){
	console.log(text);
	text.style.backgroundColor = "white";
	console.log(text);
	if (text.value == ""){
		var item = document.createElement("span");
		item.innerHTML = "Field cannot be empty!";
		text.style.backgroundColor = "#f7f7f7";
		var parentDiv = text.parentNode;
		parentDiv.insertBefore(item, text);
		//text.parentNode.appendChild(item);
		return false;
	}
	return true;
}

function isCorrectLogin (text){
	var reg = /\w/gi;
	var array = text.value;
	text.style.backgroundColor = "white";
	for (var i = 0; i < array.length; i++){
		var regTesting = reg.test(array[i]);
		if (regTesting == false){
			var item = document.createElement("span");
			item.innerHTML = "Login must consist of numbers and latin letters.";
			text.style.backgroundColor = "#f7f7f7";
			var parentDiv = text.parentNode;
			parentDiv.insertBefore(item, text);
			return false;
		}
		return true;
	}
	if (text.value == ""){
		var item = document.createElement("span");
		item.innerHTML = "Field cannot be empty!";
		text.style.backgroundColor = "#f7f7f7";
		var parentDiv = text.parentNode;
		parentDiv.insertBefore(item, text);
		return false;
	}
	return true;
	
}

function isCorrectPass1(text){
	var num = text.value;
	var item = document.createElement("span");
	if (num ==""){
		item.innerHTML = "Field cannot be empty!";
		text.style.backgroundColor = "#f7f7f7";
		var parentDiv = text.parentNode;
		parentDiv.insertBefore(item, text);
		return false;
	}
	else if (num.length<=6){
		//console.log(num);
		
		item.innerHTML = "Password must be more than 6 characters.";
		text.style.backgroundColor = "#f7f7f7";
		var parentDiv = text.parentNode;
		parentDiv.insertBefore(item, text);
		return false;
	}
	return true;
}
			
function isCorrectPass1Pass2(text1,text2){
	var item2 = document.createElement("span");
	
	if (text2.value == ""){
		item2.innerHTML = "Field cannot be empty!";
		text2.style.backgroundColor = "#f7f7f7";
		var parentDiv = text2.parentNode;
		parentDiv.insertBefore(item2, text2);
		return false;
	}

	else if (text1.value !== text2.value){
		item2.innerHTML = "Passwords don't match";
		text2.style.backgroundColor = "#f7f7f7";
		var parentDiv = text2.parentNode;
		parentDiv.insertBefore(item2, text2);
		return false;
	}
	return true;
}

function isCorrectMail(text){
	var reg = /\w+@\w+\.[a-z]{2,3}/gi;
	var array = text.value;
	text.style.backgroundColor = "white";
	var regTesting = reg.test(array);
		if (text.value == ""){
			var item = document.createElement("span");
			item.innerHTML = "Field cannot be empty!";
			text.style.backgroundColor = "#f7f7f7";
			var parentDiv = text.parentNode;
			parentDiv.insertBefore(item, text);
			return false;
		}
		else if (regTesting == false){
			var item = document.createElement("span");
			item.innerHTML = "<br>E-mail записан неверно:)";
			text.style.backgroundColor = "#f7f7f7";
			var parentDiv = text.parentNode;
			parentDiv.insertBefore(item, text);
			return false;
		}
	return true;
}
	

