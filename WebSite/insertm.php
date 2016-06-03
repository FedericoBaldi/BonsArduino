<?php
$id_pianta="1"; //You can easy make a page where insert bonsai trees, I made it statical for semplicity.

$vtemp=$_GET["vtemp"];
$vlux=$_GET["vlux"];
$vumidity=$_GET["vumidity"];
$vsoilmoisture=$_GET["vsoilmoisture"];

$namedb="sbonsarduino";
$localhost="localhost";
$user="root";
$psw="root";
$nameDB="localhost";
$connetion = mysqli_connect($nameDB,$user,$psw,$namedb);

$currentdate=date("Y-m-d"); //Get current date
$currenttime=date("h:i:sa"); //Get server's current time

$sql=($connection,"INSERT INTO measurements (Date,Hour,ID_Size,ID_Plant,Value)VALUES ('".$currentdate."','".$currenttime."',1,'".$id_plant."','".$vtemp."');"); //Insert Temperature
$query=mysqli_query($sql);

$sql=($connection,"INSERT INTO measurements (Date,Hour,ID_Size,ID_Plant,Value)VALUES ('".$currentdate."','".$currenttime."',2,'".$id_plant."','".$vlux."');"); //Insert Brightness
$query=mysqli_query($sql);

$sql=($connection,"INSERT INTO measurements (Date,Hour,ID_Size,ID_Plant,Value)VALUES ('".$currentdate."','".$currenttime."',3,'".$id_plant."','".$vumidity."');"); //Insert Umidity
$query=mysqli_query($sql);

$sql=($connection,"INSERT INTO measurements (Date,Hour,ID_Size,ID_Plant,Value)VALUES ('".$currentdate."','".$currenttime."',4,'".$id_plant."','".$vsoilmoisture."');"); //Insert Soil moisture
$query=mysqli_query($sql);
mysqli_close;
?>
