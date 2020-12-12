
<?php
if (isset($_GET['deleId'])) {
$id = $_GET['deleId'];
try {
$db = new SQLite3('../games.sqlite');

$query = "Delete from storefront where s_storeid = ". $id;
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
<title>Stores<Customer/title>    
<link rel="stylesheet" type="text/css">    
</head>    
<body>    
<h2 style="margin-left:85px;font-size: 55px;">Stores</h2><br> 
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

$result = $db->query('select * from storefront');

foreach ($result as $row ) {

echo "<tr><td>".$row['s_storeid']."</td>".
"<td>".$row['s_name']."</td>".
"<td>".$row['s_email']."</td>".
"<td>".$row['s_pass']."</td>".
"<td>".$row['s_phone']."</td>".
"<td>".$row['s_addy']."</td>".
"<td><a href='viewStoreFront.php?deleId=".$row['s_storeid'] ."'>Delete</a></td></tr>";
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
