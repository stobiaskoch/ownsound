$(document).ready(function() {
	$('#search').keyup(function() {
		if($(this).val().length >= 1) {
			$.get("rpc.php", {search: $(this).val()}, function(data) {
				$("#results").html(data);
			});
		}
	});
});
	
	
	
	function getdata(artid){
		document.getElementById("results").innerHTML="";
		$.ajax({ url: "./album.php?artid="+artid , success: function(data){
            $("#play").html(data);		
			}
		});
	}
	
	function nocover(artid, artname){
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
	
	function playeroben(){
		$.ajax({ url: "./player.php" , success: function(data){
			$("#playeroben").html(data);
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
		$.ajax({ url: "./player.php" , success: function(data){
            $("#playeroben").html(data);
    }
    });
	}
	
	
		function settings(){
		$.ajax({ url: "./settings.php" , success: function(data){
            $("#infooben").html(data);
			}
		});
	}
			function settingsclose(){
				document.getElementById("information").innerHTML="<center><img src='./img/os_logo_smaller.JPG'></center>";
			}