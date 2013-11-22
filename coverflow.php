<?php
require_once('config.inc.php');
include('./js/functions.php');
$db_link = mysqli_connect (DBHOST, DBUSER, DBPASS, DBDATABASE );
$sql = "SELECT * FROM album WHERE artist='18' ORDER BY name";
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysqli_error());
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Flipster Demo</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=550, initial-scale=1">
    

    <link rel="stylesheet" href="./js/jquery.flipster.css">

</head>
<body>
<header id="Main-Header">
	<a href="index.html" class="Button Small Float-Right">Return to Overview</a>
	<h1>Flipster Demo: Simple Carousel</h1>
</header>
<div id="Main-Content">
	<div class="Container">
<!-- Flipster List -->	
		<div class="flipster">
		  <ul>
		  	
			
			<?php
				while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{				$albumID = $zeile['id'];
		  		echo "<li><a href='na'><img src='get.php?picid=".$albumID."' width='368' height='140'>";
				echo getalbum($albumID);
				echo "</a></li>";

				}
				?>
		  </ul>
		</div>
<!-- End Flipster List -->

	</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="./js/jquery.flipster.js"></script>
<script>
<!--

	$(function(){ 
		$(".flipster").flipster({
			style: 'carousel'
		});
	});

-->
</script>
</body>
</html>
