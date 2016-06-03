<?php
session_start();
if(isset($_SESSION['access']))
{
	$username=$_SESSION['accesso'];	
	$nameDB = $_SESSION['nameDB'];
	$user = $_SESSION['user'];
	$psw = $_SESSION['psw'];
	$namedb= $_SESSION['namedb'];
}
else
{
	header("location: index.php");
}
if(isset($_POST['submit2']))
{
	session_destroy();
	header("location: index.php");
}
$json_string=file_get_contents("http://api.openweathermap.org/data/2.5/weather?id=6534499&lang=it&units=metric&APPID=8e83b0ce5baa09be921fcea0a1f76e99"); //weather API used to know my place weather.
//echo $json_string; All server response (json)
$parsed_json = json_decode($json_string); //Decode
echo "<br>";
foreach ($parsed_json->weather as $app) {
  echo $app->description;
}
?>
<html>
    <head>
        <title>BonsArduino</title>
    </head>
    <body>
    	<h1>
    	Your Bonsai trees:
    	</h1>
        <h2>
		<?php
		$connection = mysqli_connect($nameDB,$user,$psw,$namedb);
		if(!$connection) echo('<script>alert("Db connection error");</script>');
		else
		{
			$plants = mysqli_query($connection,"SELECT ID_Plant, Specie FROM plants INNER JOIN users ON plants.ID_User=users.ID_User WHERE users.Username='".$username."';");
			$rows = mysqli_num_rows($plants);
			if ($rows== 0) echo '0 Plants';
			else
			{
				while($row = mysqli_fetch_assoc($piante))
				{
						$idpianta = $row['ID_Pianta'];
						echo ''.$row['Specie'].'';
						$plants2 = mysqli_query($connection,"SELECT Date,Hour,sizes.Type,Value FROM measurements INNER JOIN sizes ON measurements.ID_sizes=sizes.ID_Sizes WHERE ID_Plants='".$idplant."' ORDER BY Date,Hour;"); //Extract data from db
						$rows2 = mysqli_num_rows($plants2);
						if ($rows2== 0) echo 'None Measurements';
						else
						{
							echo'<form id="tabpiante"><table>
									  <tr style="font-weight: bold; text-align:center" >
										<td>Date</td>
										<td>Hour</td> 
										<td>Sizes</td>
										<td>Value</td>
									  </tr>';
							while($row2 = mysqli_fetch_assoc($plants2))
							{
								echo '<tr style="text-align:center">
										<td>'.$row2['Date'].' </td>
										<td>'.$row2['Hour'].'</td> 
										<td>'.$row2['Type'].'</td>
										<td>'.$row2['Value'].'</td>
									  </tr>';
							}
							echo ' </table></form>';
						}
				}
			}
		}
		mysqli_close($connection);
		?>
		</h2>	
    </body>
</html>
