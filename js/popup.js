jQuery(function($) {
 
    var popup_zustand = false;
 
    $(".popup_oeffnen").click(function() {
 
        if(popup_zustand == false) {
            $("#popup").fadeIn("normal");
					$.ajax({ url: "./settings.php" , 
			success: function(data){
					$("#popup_inhalt").html(data);
			}
		});
            $("#hintergrund").css("opacity", "0.7");
            $("#hintergrund").fadeIn("normal");
            popup_zustand = true;
        }
 
    return false;
    });
 
    $(".schliessen").click(function() {
 
        if(popup_zustand == true) {
            $("#popup").fadeOut("normal");
            $("#hintergrund").fadeOut("normal");
            popup_zustand = false;
        }
 
    });
 
});