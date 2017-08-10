function populateSelectbox(obj,value) {
	for(i = 0; i<obj.length; i++)
		if (obj[i].value.toLowerCase() == value.toLowerCase()) 
			obj[i].selected = true;
}

function isNumberKey(evt) {
	if(evt.which!=0) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	} else {
		return true;
	}
}