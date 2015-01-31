function affiche(obj){
	var id = obj.id;
	
	for(var i = 2; i <= 3; i++){
		document.getElementById('sousmenu'+i).style.display = "none";
	}
	
	if(document.getElementById('sous'+id)){
		document.getElementById('sous'+id).style.display = "block";
	}
}

$(document).ready( function() {
$('.dropdown-toggle').dropdown();
});