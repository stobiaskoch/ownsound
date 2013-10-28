<?php
mysql_connect("localhost", "root","strese84");
mysql_select_db("musikdatenbank") or die ("Die Datenbank existiert nicht.");
$picid = $_REQUEST['picid'];
$size = $_REQUEST['size'];
$query = "select imgdata,imgtype,imgdata_small from album where id=$picid"; 
$result = @MYSQL_QUERY($query); 
if($size=="small") {
$data = @MYSQL_RESULT($result,0,"imgdata_small"); 
}
else
{
$data = @MYSQL_RESULT($result,0,"imgdata"); 
}


$type = @MYSQL_RESULT($result,0,"imgtype"); 

Header( "Content-type: $type"); 


if($data!="") {echo $data;}
else 
{

echo readfile('no_cover.jpg');

}




?>
