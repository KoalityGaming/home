function populate() {

	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
			
		var servers = JSON.parse(xmlhttp.responseText);
		
		var ttt = servers["Trouble In Terrorist Town"]
		
		
		var playersDiv = document.getElementById("ttt").getElementsByClassName("players")[0];
		playersDiv.innerHTML = ttt.players
		
		var mapDiv = document.getElementById("ttt").getElementsByClassName("map")[0];
		mapDiv.innerHTML = ttt.map
		
		var mapImage = document.getElementById("ttt").getElementsByClassName("mapimage")[0];
		
		console.log(mapImage)
		
		var url = "http://image.www.gametracker.com/images/maps/160x120/garrysmod/"
		url = url.concat(ttt.map)
		url = url.concat(".jpg")
		mapImage.src = url
					
		
		var gg = servers["Gun Game"]
		
		
		var playersDiv = document.getElementById("gg").getElementsByClassName("players")[0];
		playersDiv.innerHTML = gg.players
		
		var mapDiv = document.getElementById("gg").getElementsByClassName("map")[0];
		mapDiv.innerHTML = gg.map
		
		var mapImage = document.getElementById("gg").getElementsByClassName("mapimage")[0];
		
		console.log(mapImage)
		
		var url = "http://image.www.gametracker.com/images/maps/160x120/garrysmod/"
		url = url.concat(gg.map)
		url = url.concat(".jpg")
		mapImage.src = url
	}
	
	xmlhttp.open("GET","ServerHopper.php",true);
	xmlhttp.send();
	
	
						
}
