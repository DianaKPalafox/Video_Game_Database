<?php
if (isset($_GET['deleId'])) {
$id = $_GET['deleId'];

try {
$db = new SQLite3('games.sqlite');

$query = "Delete from customer Where c_custid = ".$id;
$db->exec($query);

}catch (Exception $e) {
echo $e->getMessage();
}
finally
{
$db = null;
}
}
?>


<!DOCTYPE html>    
<html>    
<head>    
<title>Customers</title>    
<link rel="stylesheet" type="text/css">    
</head>    
<body>    
<h2 style="margin-left:85px;font-size: 55px;">Customers</h2><br> 
<table style="width: 61%;
margin-left: 255px;">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Password</th>
<th>Phone</th>
<th>Address</th>
<th>Options</th>
</tr>

<?php
try {

$db = new PDO('sqlite:games.sqlite');

$result = $db->query('select * from customer');

foreach ($result as $row ) {

echo "<tr><td>".$row['c_custid']."</td>".
"<td>".$row['c_name']."</td>".
"<td>".$row['c_email']."</td>".
"<td>".$row['c_pass']."</td>".
"<td>".$row['c_phone']."</td>".
"<td>".$row['c_addy']."</td>".
"<td><a href='viewData.php?deleId=".$row['c_custid'] ."'>Delete</a></td></tr>";

}
} catch (PDOException $e) {
echo $e->getMessage();
}
finally{
$db = null;
}
?>

</table>
</div>    
</body>    
</html>  

