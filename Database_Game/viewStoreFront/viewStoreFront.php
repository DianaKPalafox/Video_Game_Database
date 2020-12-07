<?php
	if (isset($_GET['deleteId'])) {
		$id = $_GET['deleteId'];
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
    <title>Customers</title>    
    <link rel="stylesheet" type="text/css">    
</head>    
<body>    
    <h2 style="margin-left:90px;font-size: 50px;">Stores</h2><br> 
	<table style="width: 60%;
    margin-left: 250px;">
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


			$db = new PDO('sqlite:../games.sqlite');

			$result = $db->query('select * from storefront');

			foreach ($result as $row ) {

				echo "<tr><td>".$row['s_storeid']."</td>".
				"<td>".$row['s_name']."</td>".
				"<td>".$row['s_email']."</td>".
				"<td>".$row['s_pass']."</td>".
				"<td>".$row['s_phone']."</td>".
				"<td>".$row['s_addy']."</td>".
				"<td><a href='viewStoreFront.php?deleteId=".$row['s_storeid'] ."'>Delete</a> ".
				"<a href='../RegisterStore/RegisterStore.php?id=".$row['s_storeid'] ."'>Edit</a></td></tr>";
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