<?php
	if (isset($_GET['deleteId'])) {
		$id = $_GET['deleteId'];
		try {
            $db = new SQLite3('../games.sqlite');

			$query = "Delete from customer where c_custid = ".$id;
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
    <h2 style="margin-left:90px;font-size: 50px;">Customers</h2><br> 
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

			$result = $db->query('select * from Customer');

			foreach ($result as $row ) {
				
				echo "<tr><td>".$row['c_custid']."</td>".
				"<td>".$row['c_name']."</td>".
				"<td>".$row['c_email']."</td>".
				"<td>".$row['c_pass']."</td>".
				"<td>".$row['c_phone']."</td>".
				"<td>".$row['c_addy']."</td>".
				"<td><a href='viewData.php?deleteId=".$row['c_custid'] ."'>Delete</a> ".
				"<a href='../addRegister/Register.php?id=".$row['c_custid'] ."'>Edit</a></td></tr>";
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