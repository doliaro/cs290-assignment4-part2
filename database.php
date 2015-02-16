<html>
<head>
<title> Data View </title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"></script>

</head>
<body>

<form action="" method="post">
<h1>
<font size="15" face="Monotype Corsiva" color="black">
<center>Video Story Inventory</center></font></h1>
<form>
	<table>
		<tr>
		    	<td width="50%"> Title: </td> 
		    	<td> <input type="text" name="mname" /></td>
		</tr>
		<tr>
		    	<td width="50%"> Category: </td>
		    	<td> <input type="text" name="cat"/></td>
		</tr>
		<tr>
		        <td width="50%"> Length: </td> 
		        <td><input type="text" name="length" /></td>
		</tr>
	</table>
	<br/>
</br></br>
<input type="submit" name="submit1" value="Add Video"/>
<input type="submit" name="delete_all" value="Delete All Videos"/>
<form method="get" action="database.php">

<?php
include 'pass.php';
	

ini_set('display_errors', 'On');
//include 'pass.php';

//$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "oliarod-db", $my_password, "oliarod-db");
$conn = new mysqli("oniddb.cws.oregonstate.edu", "oliarod-db", $my_password, "oliarod-db");

//$conn = mysql_connect("127.0.0.1", "mysql", "");
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
echo 'Connected to database';
echo "<br />";
//Create Database
// $sql = "CREATE DATABASE oliarod-db";
// if ($conn->query($sql) === TRUE) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . $conn->error;
// }
//Create Table
// $sql = "CREATE TABLE Inventory(
// 	id INT PRIMARY KEY AUTO_INCREMENT,
// 	name VARCHAR(255) UNIQUE NOT NULL, 
// 	category VARCHAR(255) NOT NULL,
// 	length INT, 
// 	rented BOOL
// )";
// $conn->select_db('oliarod-db');
// $result = mysqli_query($conn,$sql);
// if(! $result )
// {
//   die('Could not create table: ' . mysql_error());
// }
// echo "Table inventory created successfully\n";
$conn->select_db('oliarod-db');

$sql=mysqli_query($conn,"SELECT DISTINCT category FROM Inventory");
		echo "<select name=\"category\">"; 
		echo "<option size =30 ></option>";
		while($row = mysqli_fetch_array($sql)) 
		{        
		echo "<option value='" . $row['category'] . "'>" . $row['category'] . "</option>"; 
		}
		echo "</select>";

$result = mysqli_query($conn, "SELECT id,name,category,length,rented FROM Inventory");

$movie_id;
echo "<table border='1'>
<tr>
<th>Name</th>
<th>Category</th>
<th>Length</th>
<th>Rented</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
  echo "<tr>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['category'] . "</td>";
  echo "<td>" . $row['length'] . "</td>";
 
  echo "<form method='get' action='database.php'>
  <td><input name='rented' type='checkbox' id='rented' value='Rented'></td>
  </form>";

  echo "<form method='post' action='database.php'>
  <td><input name='delete' type='submit' id='delete' value='Delete'></td>
  </form>";
  echo "</tr>";
  $movie_id = $row['id'];
}
echo "</table>";


//add a new video
if(isset($_POST['submit1'])){
$id_value=0;
$name=$_POST['mname'];
$category=$_POST['cat'];
$length=$_POST['length'];
$rented='available';
$sql = "INSERT IGNORE INTO Inventory VALUES('$id_value','$name','$category','$length', '$rented')";

if (!mysqli_query($conn, $sql))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record added";

}
//delete a selected video row
if(isset($_POST['delete'])){

$sql = "DELETE FROM Inventory WHERE id = $movie_id";

mysqli_select_db($conn, 'oliarod-db');
$retval = mysqli_query($conn, $sql);
if(! $retval )
{
  die('Could not delete data: ' . mysql_error());
}
echo "Deleted data successfully\n";
}
//delete all videos
if(isset($_POST['delete_all'])){

$sql = "TRUNCATE TABLE Inventory";

$delete_data = mysqli_query($conn, $sql);
	
if(!$delete_data)
{
  die('Could not delete data: ' . mysql_error());
}
echo "Deleted data successfully\n";
}
if(isset($_POST['rented'])){
	$sql = "UPDATE 'Inventory' SET '0' = '1' WHERE rented='0'";

	$update_rent = mysqli_query($conn, $sql);
if(!$update_rent)
{
  die('Could not update rented ' . mysql_error());
}
echo "Updated rented\n";
}	

$_POST = array();
mysqli_close($conn);
?>
</body>
</html>







