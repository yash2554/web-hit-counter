<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Hit viewer</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
	include("counter_config.php");
	
// ###########################
// ### Connect to database ###
// ###########################

$link = mysql_connect($localhost, $dbuser, $dbpass); 

//add your website-url here
if (!$link) 
	{
		header("Location: ");
	}
	
$db_selected = mysql_select_db($dbname, $link);

if (!$db_selected) 
	{
	    die ('Can\'t use database : ' . mysql_error());
	}


// ######################
// ### get total hits ###
// ######################
	
	$query = "SELECT SUM(count)  AS totalhits FROM hits"; 
	 
	$result = mysql_query($query) or die(mysql_error());

	
	while($row = mysql_fetch_array($result))
	{
		$totalhits = $row['totalhits']  ;
	}

// ####################
// ### Display hits ###
// ####################

	echo '<h3>Hits</h3>' ;

	$result = mysql_query("SELECT * FROM " . $dbtablehits . " ORDER BY count DESC");
	
	echo "<table width='100%' border='0'>";
	echo '	<tr>
		<td height="2" bgcolor=" #8a8a5c" width="400">Page</td> 
		<td height="2" bgcolor=" #8a8a5c" width="169"> Hits</td>
		</tr>' ;

	// keeps getting the next row until there are no more to get
	while($row = mysql_fetch_array( $result )) 
	{
	// Print out the contents of each row into a table
	echo '<tr><td bgcolor="#adad85">'; 
	echo $row['page'];
	echo '</td><td bgcolor="#adad85">'; 
	echo $row['count'];
	echo '</td></tr>'; 
	} 
	echo "<tr><td bgcolor=\" #8a8a5c\"> <strong> Total Hits </strong> </td><td bgcolor=\" #8a8a5c\"> <strong> $totalhits </strong> </td></tr>" ;
	echo "</table><br /> ";

// ############################
// ### get total unique IPs ###
// ############################

$result=mysql_query("SELECT MAX(id) FROM info");
while ($row = mysql_fetch_array($result, MYSQL_NUM)) 
{
$totalips = $row[0] ;  
}


// ########################
// ### Display visitors ###
// ########################

echo '<h3> Visitors </h3>' ;

$result = mysql_query("SELECT * FROM $dbtableinfo ORDER BY id DESC") 
or die(mysql_error());  

echo "<table width='100%' border='0'>";
echo '<tr> <td width="200" bgcolor=" #8a8a5c">  IP {Geo-Location} </td> <td height="2" bgcolor=" #8a8a5c" width="400">User agent</td> <td height="2" bgcolor=" #8a8a5c" width="169"> Date &amp; Time</td><td height="2" bgcolor=" #8a8a5c" width="169"> Track IP Information</td></tr>';

// keeps getting the next row until there are no more to get
while($row = mysql_fetch_array( $result )) 
{
	// Print out the contents of each row into a table
	echo '<tr><td bgcolor="#adad85">'; 
	echo $row['location'];
	echo '</td><td bgcolor="#adad85">'; 
	echo $row['user_agent'];
	echo '</td><td bgcolor="#adad85">'; 
	echo $row['datetime'];
	echo '</td><td bgcolor="#adad85">';
	echo $row['info'];
	echo "</td></tr>"; 		
} 
	echo "<tr><td bgcolor=\" #8a8a5c\"> <strong> Total unique IP´s </strong> </td><td bgcolor=\" #8a8a5c\"> <strong> $totalips </strong> </td></tr>" ;
	echo "</table><br /> ";
?>

</body>
</html>

