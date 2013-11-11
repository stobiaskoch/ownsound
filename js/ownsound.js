$(document).ready(function() {
	$('#search').keyup(function() {
		if($(this).val().length >= 1) {
			$.get("rpc.php", {search: $(this).val()}, function(data) {
				$("#results").html(data);
			});
		}
	});




	
});




		function google(artistID, albumID){
		$.ajax({ url: "./google.php?order=search&artistID="+artistID+"&albumID="+albumID , success: function(data){
            $("#content").html(data);
    }
    });
	}
	
				function googledownload(pic, albumID, artistID){
		$.ajax({ url: "./google.php?order=save&url="+pic+"&albumID="+albumID+"&artistID="+artistID});
		sleep(2000);
		$.ajax({ url: "./title.php?albumID="+albumID+"&artistID="+artistID , success: function(data){
            $("#playalbum").html(data);
            stats();
    }
    });
			
			getdataalbum(albumID, artistID);
	}











	function getdatabig(artid, artname, limit){
		document.getElementById("results").innerHTML="";
		$.ajax({ url: "./album.php?artid="+artid+"&artname="+artname+"&limit="+limit , success: function(data){
            $("#play").html(data);		
			}
		});
	}



	function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name,"",-1);
	}

	
	function getdataalbum(albumID, artistID){
		$.ajax({ url: "./title.php?albumID="+albumID+"&artistID="+artistID , success: function(data){
            $("#play").html(data);
    }
    });
	}
	
	function getdata(artid){
		document.getElementById("results").innerHTML="";
		$.ajax({ url: "./album.php?artid="+artid , success: function(data){
            $("#play").html(data);		
			}
		});
	}
	
	function nocover(){
		document.getElementById("results").innerHTML="";
		$.ajax({ url: "./nocover.php" , success: function(data){
            $("#play").html(data);		
			}
		});
	}
	
	function getdatanewcover(artid, artname){
		$.ajax({ url: "./album.php?artid="+artid+"&artname="+artname+"#gshd" , success: function(data){
            $("#play").html(data);
			}
		});
	}
	
	function stats(){
		$.ajax({ url: "./databasestats.php" , success: function(data){
            $("#stats").html(data);
			}
		});
	}
	
	function player(){
		$.ajax({ url: "./player.php" , success: function(data){
			$("#playlist").html(data);
			}
		});
	}

	function playlist(){
		$.ajax({ url: "./player.php" , success: function(data){
			$("#playlist").html(data);
			}
		});
	}
	
	function sleep(milliseconds) {
		  var start = new Date().getTime();
		  for (var i = 0; i < 1e7; i++) {
			if ((new Date().getTime() - start) > milliseconds){
			  break;
			}
		  }
	}
			
			
	function addalbum(order, albumid, artistid){
		$.ajax({ url: "./addplaylist.php?order="+order+"&albumID="+albumid+"&artistID="+artistid});
		sleep(500);
		playlist();
	}
	
	function zipalbum(albumID){
		window.open("./zip.php?albumID="+albumID, "zip");   
	}
	
		function settings(){
		$.ajax({ url: "./settings.php" , success: function(data){
	            $("#information").html(data);

			}
		});
	}
	
	
			function settingsclose(){
				document.getElementById("information").innerHTML="<center><img src='./img/os_logo_smaller.JPG'></center><div style='font-size: 12px; top: 260px; left: 868px; position:fixed;'><a href='https://github.com/stobiaskoch/ownsound'><img src='./img/git.gif'></a></div>";
			}
			
			
	function deletetitle(titleID, albumID, artistID){
		$.ajax({ url: "./delete.php?order=deletetitle&titleID="+titleID , success: function(data){
			getdataalbum(albumID, artistID);
    }
    });
	}
	
	function deletealbum(albumID, artistID){
		$.ajax({ url: "./delete.php?order=deletealbum&albumID="+albumID , success: function(data){
			getdata(artistID);
    }
    });
	}
	
	function deleteartist(artistID){
		$.ajax({ url: "./delete.php?order=deleteartist&artistID="+artistID , success: function(data){
    }
    });
	}		